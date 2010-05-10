<?php

require_once("../shared/common.php");
require_once('Query.php');

class BiblioCoverQuery extends Query {
  function lookup($isbn, $debug = false) {
    // Hide warnings on results in safe mode
    error_reporting(0);
    // Lookup amazon first
    require_once('cloudfusion/cloudfusion.class.php');
    
    // Load cover options
    require_once('../classes/CoverOptsQuery.php');
    $opt = CoverOptsQuery::getAWS();
    define('AWS_KEY', $opt['aws_key']);
    define('AWS_SECRET_KEY', $opt['aws_secret_key']);
    define('AWS_ACCOUNT_ID', $opt['aws_account_id']);

    // Remove trail data from ISBN
    $isbn = explode(' ', $isbn);
    $isbn = $isbn[0];
    
    $pas = new AmazonPAS();
    $response = $pas->item_lookup($isbn, array(
      'IdType'=>'ISBN',
      'SearchIndex'=>'Books',
      'ResponseGroup'=>'Images'));

    if ($debug) 
      return $response;
    
    if (!empty($response->body->Items->Item->MediumImage)) {
      return ''.$response->body->Items->Item->MediumImage->URL;
    }
    return false;
  }
  
  function save($path, $bibid) {
    // Manipulate image (~160x160px) then save file
    // Don't forget to save MARC field with bibid
    
    // Save temporary file.
    if (!function_exists('imagecreatefromjpeg')) return false;
    
    $img_bin = file_get_contents($path);
    if (!$img_bin || strlen($img_bin) < 1) return false;
    
    // Create directory when necessary, raise error when failed to create "not exist" one.
    if (!(is_dir('..' . COVER_PATH) || is_dir('..', COVER_PATH_TMP))) {
      $dir_error = FALSE;
      if (is_dir('..' . dirname(COVER_PATH))) {
        // Create new one.
        $cover_path = @mkdir('..' . COVER_PATH, 0777);
        $tmp_path = @mkdir('..' . COVER_PATH_TMP, 0777);
        
        if (!$cover_path) {
          if (is_dir('..' . COVER_PATH)) {
            if (decoct(fileperms('..' . COVER_PATH)) != 0777) {
              $force_chmod = @chmod('..' . COVER_PATH, 0777);
              if (!$force_chmod) {
                $dir_error = TRUE;
              }
            }
          }
          else {
            $dir_error = TRUE;
          }
        }
        
        if (!$tmp_path) {
          if (is_dir('..' . COVER_PATH_TMP)) {
            if (decoct(fileperms('..' . COVER_PATH_TMP)) != 0777) {
              $force_chmod = @chmod('..' . COVER_PATH_TMP, 0777);
              if (!$force_chmod) {
                $dir_error = TRUE;
              }
            }
          }
          else {
            $dir_error = TRUE;
          }
        }
        
        if ($dir_error) {
          print_r('<span style="color: red"><strong>Error:</strong> Failed to save book cover! please set chmod 777 to /media directory.</span><br />');
          return false;
        }
      }
    }
    
    // http://somewhere/path/to/file.name.ext
    // result: file.name
    // 
    $name_full = substr($path, strrpos($path, '/') + 1); // file.name.ext
    $path_tmp = '..' . COVER_PATH_TMP . '/' . substr($hash, strlen($hash) - 7) . '_' . $name_full;
    
    if (!file_put_contents($path_tmp, $img_bin)) return false;
    
    $img_info = @getimagesize($path_tmp);
    $ext = image_type_to_extension($img_info[2]);
    $hash = md5($path.session_id().time());
    if ($ext == '.jpeg') $ext = '.jpg';
    $name = str_replace('%', '', substr($name_full, 0, strrpos($name_full, '.')) . "_" . substr($hash, strlen($hash) - 7) . $ext);
    $path_local = '..' . COVER_PATH . '/' . $name;
    
    switch ($img_info['mime']) {
      case 'image/jpeg':
        $create_func = 'imagecreatefromjpeg';
        $output_func = 'imagejpeg';
      break;
      case 'image/png':
        $create_func = 'imagecreatefrompng';
        $output_func = 'imagepng';
      break;
      case 'image/gif':
        $create_func = 'imagecreatefromgif';
        $output_func = 'imagegif';
      break;
    }
    
    // Scale size to height 160px.
    $resize_width = floor($img_info[0] * ( 160 / $img_info[1] ));
    $resize_height = 160;
    
    $src = $create_func($path_tmp);
    $dst = imagecreatetruecolor($resize_width, $resize_height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $resize_width, $resize_height, $img_info[0], $img_info[1]);
    $file_saved = $output_func($dst, $path_local);
    imagedestroy($src);
    imagedestroy($dst);
    unlink($path_tmp);
    
    if (!$file_saved) return false;
    
    // Save to field
    if (0 + $bibid > 0) {
      if( !$this->_query("INSERT INTO biblio_field 
       (bibid, tag, ind1_cd, ind2_cd, subfield_cd, field_data) 
       VALUES (" . (0 + $bibid) . ", 902, 'N', 'N', 'a', '$name');", false) ) {
        unlink($path_local);
        return false;
      }
    }
    else {
      return $name; // bibid = 0 then return filename for save to db later
    }
    return true;
  }
  
  private function _getLookupResult($server, $isbn) {
    // Now support YAZ only
    $query = '@attr 1=7 ' . $isbn;
    $conn = yaz_connect($server['host'], 
     array('user'=>$server['user'], 'password'=>$server['pw']));
    
    if (!$conn) return false;
    yaz_database($conn, $server['db']);
    yaz_syntax($conn, "usmarc");
    yaz_element($conn, "F");

    if (! yaz_search($conn, 'rpn', $query)) return false;
    
    yaz_wait();
    $error = yaz_error($conn);
    if (!empty($error)) {
      return false;
    }
    
    if (yaz_hits($conn) < 1) {
      return false;
    }
    // For bulk actions, auto select first record
    require_once("../lookup2/lookupYazFunc.php");
    $data = extract_marc_fields(yaz_record($conn, 1, 'array'), true, 1, 1);
    return $data['856u'];
  }
}
