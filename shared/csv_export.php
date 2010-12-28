<?php
  require_once("../shared/common.php");
  require_once("../classes/Query.php");

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $q = new Query();
    $tables = array(
                "biblio",
                "biblio_copy",
                "biblio_field",
                "biblio_hold",
                "biblio_status_dm",
                "biblio_status_hist",
                "checkout_privs",
                "collection_dm",
                "cover_options",
                "material_type_dm",
                "material_usmarc_xref",
                "mbr_classify_dm",
                "member",
                "member_account",
                "member_fields",
                "member_fields_dm",
                "settings",
                "staff",
                "transaction_type_dm"
              );
    $output_file = "openbiblio_hotri_export_".date("Ymd").".zip";
    export_zip($tables, $output_file);
    $q->close();
  }

  // Functions -----------------------------------------------------------------

  function export_zip($tables, $output_file) {
    $output_folder = sys_get_temp_dir() ."/openbiblio_export";
    if (!file_exists($output_folder)) {
      mkdir($output_folder);
    }

    foreach ($tables as $table) {
      create_csv($table, $output_folder);
    }

    $output_file = sys_get_temp_dir() ."/". $output_file;
    $files = scandir($output_folder);
    if (create_zip($files, $output_folder, $output_file, true)) {
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=$output_file"); 
      header("Content-Transfer-Encoding: binary");
      readfile($output_file);
    } else {
      print "Cannot export a zipped file.";
    }
  }

  function create_csv($table, $output_folder) {
    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";
    $sql_query = "SELECT * FROM $table";
 
    // Gets the data from the database
    $result = mysql_query($sql_query);
    $fields_cnt = mysql_num_fields($result);
 
    $schema_insert = '';
 
    for ($i = 0; $i < $fields_cnt; $i++)
    {
      $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
          stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
      $schema_insert .= $l;
      $schema_insert .= $csv_separator;
    } // end for
 
    $out = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;
 
    // Format the data
    while ($row = mysql_fetch_array($result))
    {
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++)
        {
            if ($row[$j] == '0' || $row[$j] != '')
            {
                if ($csv_enclosed == '')
                {
                    $schema_insert .= $row[$j];
                }
                else
                {
                    $schema_insert .= $csv_enclosed . 
                    str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
                }
            }
            else
            {
                $schema_insert .= '';
            }
 
            if ($j < $fields_cnt - 1)
            {
                $schema_insert .= $csv_separator;
            }
        } // end for
 
        $out .= $schema_insert;
        $out .= $csv_terminated;
    } // end while

    $output_file = $output_folder ."/". $table .".csv";
    $fp = fopen($output_file, "w");
    fwrite($fp, $out);
    fclose($fp);
  }

  /**
   * CREDIT: http://www.ineedtutorials.com/code/php/export-mysql-data-to-csv-php-tutorial 
   */
  function export_csv($table, $filename = 'export.csv') {
      $csv_terminated = "\n";
      $csv_separator = ",";
      $csv_enclosed = '"';
      $csv_escaped = "\\";
      $sql_query = "SELECT * FROM $table";
   
      // Gets the data from the database
      $result = mysql_query($sql_query);
      $fields_cnt = mysql_num_fields($result);
   
   
      $schema_insert = '';
   
      for ($i = 0; $i < $fields_cnt; $i++)
      {
          $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
              stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
          $schema_insert .= $l;
          $schema_insert .= $csv_separator;
      } // end for
   
      $out = trim(substr($schema_insert, 0, -1));
      $out .= $csv_terminated;
   
      // Format the data
      while ($row = mysql_fetch_array($result))
      {
          $schema_insert = '';
          for ($j = 0; $j < $fields_cnt; $j++)
          {
              if ($row[$j] == '0' || $row[$j] != '')
              {
   
                  if ($csv_enclosed == '')
                  {
                      $schema_insert .= $row[$j];
                  } else
                  {
                      $schema_insert .= $csv_enclosed . 
            str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
                  }
              } else
              {
                  $schema_insert .= '';
              }
   
              if ($j < $fields_cnt - 1)
              {
                  $schema_insert .= $csv_separator;
              }
          } // end for
   
          $out .= $schema_insert;
          $out .= $csv_terminated;
      } // end while
   
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Length: " . strlen($out));
      // Output to browser with appropriate mime type, you choose ;)
      header("Content-type: text/x-csv");
      //header("Content-type: text/csv");
      //header("Content-type: application/csv");
      header("Content-Disposition: attachment; filename=$filename");
      echo $out;
      exit;
  }

  /**
   * CREDIT: http://davidwalsh.name/create-zip-php
   */
  function create_zip($files = array(), $input_folder = '.', $output_file = '', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if(file_exists($output_file) && !$overwrite) { return false; }
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
      //cycle through each file
      foreach($files as $file) {
        //make sure the file exists
        if(file_exists($input_folder ."/". $file) && ($file != "." && $file != "..")) {
          $valid_files[] = $file;
        }
      }
    }

    //if we have good files...
    if(count($valid_files)) {
      //create the archive
      $zip = new ZipArchive();
      if($zip->open($output_file,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
        return false;
      }
      //add the files
      foreach($valid_files as $file) {
        $dirname = dirname($input_folder);
        $parent_folder = basename($input_folder);
        chdir($dirname);
        $file = $parent_folder . "/" . $file; // wraps target files with a folder
        $zip->addFile($file, $file);
      }
      //debug
      //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
      
      //close the zip -- done!
      $zip->close();
      
      //check to make sure the file exists
      return file_exists($output_file);
    }
    else
    {
      return false;
    }
  }
?>
