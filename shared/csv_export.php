<?php
  require_once("../shared/common.php");
  require_once("../classes/Query.php");

  $q = new Query();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["table"])) {
      if (isset($_POST["join"]) && $_POST["join"] == true) {
        $output = $_POST["table"];
        $table = $_POST["table"] ." ". $_POST["join"];
      } else {
        $table = $_POST["table"];
        $output = $table;
      }
      exportMysqlToCsv($table, $output.".csv");
    }
  }
  $q->close();

  /**
   * CREDIT: http://www.ineedtutorials.com/code/php/export-mysql-data-to-csv-php-tutorial 
   */
  function exportMysqlToCsv($table, $filename = 'export.csv') {
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
?>
