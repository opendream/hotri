<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  # Forcibly disable register_globals
  if (ini_get('register_globals')) {
    foreach ($_REQUEST as $k=>$v) {
      unset(${$k});
    }
    foreach ($_ENV as $k=>$v) {
      unset(${$k});
    }
    foreach ($_SERVER as $k=>$v) {
      unset(${$k});
    }
  }
  
  /****************************************************************************
   * Cover up for the magic_quotes disaster.
   * Modified from ryan@wonko.com.
   ****************************************************************************
   */
  ini_set('set_magic_quotes_runtime', 0);

  if (get_magic_quotes_gpc()) {
    function magicSlashes($element) {
      if (is_array($element))
        return array_map("magicSlashes", $element);
      else
        return stripslashes($element);
    }

    // Remove slashes from all incoming GET/POST/COOKIE data.
    $_GET    = array_map("magicSlashes", $_GET);
    $_POST   = array_map("magicSlashes", $_POST);
    $_COOKIE = array_map("magicSlashes", $_COOKIE);
    $_REQUEST = array_map("magicSlashes", $_REQUEST);
  }
  
  # FIXME - Until I get around to fixing all the notices...
  error_reporting(E_ALL ^ E_NOTICE);

  /* Work around PHP's braindead include_path stuff. */
  function REL($sf, $if) {
    return dirname($sf)."/".$if;
  }
  
  # Escaping shorthands
  function H($s) {
    return htmlspecialchars($s, ENT_QUOTES);
  }
  function HURL($s) {
    return H(urlencode($s));
  }
  function U($s) {
    return urlencode($s);
  }
  function _mkPostVars($arr, $prefix) {
    $pv = array();
    foreach ($arr as $k => $v) {
      if ($prefix !== NULL) {
        $k = $prefix."[$k]";
      }
      if (is_array($v)) {
        $pv = array_merge($pv, _mkPostVars($v, $k));
      } else {
        $pv[$k] = $v;
      }
    }
    return $pv;
  }
  function mkPostVars() {
    return _mkPostVars($_REQUEST, NULL);
  }
  
  # Compatibility
  $phpver = explode('.', PHP_VERSION);
  if (!function_exists('mysql_real_escape_string')) {   # PHP < 4.3.0
    function mysql_real_escape_string($s, $link) {
      return mysql_escape_string($s);
    }
  }
  if ($phpver[0]>=5 || ($phpver[0]==4 && $phpver[1]>=3)) {
    function obib_setlocale() {
      $a = func_get_args();
      call_user_func_array('setlocale', $a);
    }
  } else {
    function obib_setlocale() {
      $a = func_get_args();
      setlocale($a[0], $a[1]);
    }
  }
  
  require_once('../database_constants.php');
  require_once('../shared/global_constants.php');
  require_once('../classes/Error.php');
  require_once('../classes/Iter.php');
  require_once('../classes/Nav.php');
  require_once('../functions/compat.php');

  if (!isset($doing_install) or !$doing_install) {
    require_once("../shared/read_settings.php");

    /* Making session user info available on all pages. */
    session_start();
    # Forcibly disable register_globals
    if (ini_get('register_globals')) {
      foreach ($_SESSION as $k=>$v) {
        unset(${$k});
      }
    }
  }

  #*****************************************************
  #  Get image resize
  #*****************************************************
  function _image_resize($filepath, $width = NULL, $height = NULL) {
    if (!file_exists($filepath)) return 0;
    if ($info = getimagesize($filepath)) {
      if ($width > 0 && $height > 0) {
        $info[0] = $width;
        $info[1] = $height;
      }
      elseif ($width > 0) {
        $height = $width * $info[1] / $info[0];
        $info[0] = $width;
        $info[1] = $height;
      }
      elseif ($height > 0) {
        $width = $height * $info[0] / $info[1];
        $info[0] = $width;
        $info[1] = $height;
      }
      else {
        return 1;
      }
      $info[3] = "width=\"$width\" height=\"$height\"";
      return $info;
    }
    return 2;
  }

  #******************************************************
  #  Make image thumbnail
  #******************************************************
  function make_thumbnail($filepath, $info = array()) {
    if (!file_exists($filepath)) return FALSE;
    if (count($info) == 0) return FALSE;
    $paths = explode('/', $filepath);
    $fileparts = explode('.', array_pop($paths));
    // remove ext
    array_pop($fileparts);
    // combine filename
    $filename = implode('.', $fileparts);
    // get image info
    $image_info = getimagesize($filepath);
    $image_width = $image_info[0];
    $image_height = $image_info[1];
    $image_mime = $image_info['mime'];
    // get image extension
    $ext = image_type_to_extension($image_info[2]);
    if ($ext == "jpeg") {
      $ext = "jpg";
    }

    // combine thumbpath
    $paths[] = 'thumb_'.$filename.$ext;
    $thumbpath = implode('/', $paths);
    if (!file_exists($thumbpath)) {
      if (is_numeric($info['width']) && is_numeric($info['height'])) {
        $thumb_width = $info['width'];
        $thumb_height = $info['height'];
      }
      elseif (is_numeric($info['width'])) {
        $thumb_width = $info['width'];
        $thumb_height = ceil($thumb_width * $image_height / $image_width);
      }
      elseif (is_numeric($info['height'])) {
        $thumb_height = $info['height'];
        $thumb_width = ceil($image_width * $thumb_height / $image_height);
      }

      switch ($image_mime) {
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
      $src = $create_func($filepath);
      $dst = imagecreatetruecolor($thumb_width, $thumb_height);
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
      $output_func($dst, $thumbpath);
      imagedestroy($src);
      imagedestroy($dst);
    }
    return $thumbpath;
  }
  
  ###################################################################
  ## plugin Support
  ###################################################################
  function getPlugIns($wanted) {
    clearstatcache();
    $lists = array();
    if (is_dir('../plugins')) {
      //echo "Plugin Dir found: <br />";
      ## find all plugin directories
      if ($dirHndl = opendir('../plugins')) {
        # look at all plugin dirs
        while (false !== ($plug = readdir($dirHndl))) {
          if (($plug == '.') || ($plug == '..')) continue;
          //echo "plugin => $plug<br />";
          $plugPath = "../plugins/$plug";
          if (is_dir($plugPath)) {
            if ($filHndl = opendir($plugPath)) {
              while (false !== ($file = readdir($filHndl))) {
                if (($file == '.') || ($file == '..')) continue;
                //echo "file => $file<br />";
                if ($file == $wanted) $list[] = "../plugins/$plugPath/$file";
              }
              closedir($filHndl);
            }
          }
        }
        closedir($dirHndl);
      }
    }
    return $list;
  }

  #******************************************************
  #  Utility functions
  #******************************************************
  function sanitize_input($input) {
    $output = preg_replace("/[[:space:]]+/i", " ", trim($input));
    $output = preg_replace("/'/", "", $output);
    $output = preg_replace("/\\\\/", "", $output);
    return $output;
  }
?>
