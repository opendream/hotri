<?php
  require_once("../shared/common.php");
  require_once("../classes/Query.php");

  $tab = "circulation";
  require_once("../shared/logincheck.php");

  $ret = "";
  $sql = "SELECT MAX(barcode_nmbr) AS bn FROM member"; 
  $q = new Query(); 
  $rows = $q->exec($sql);
  if (count($rows) > 0) {
    $bn = $rows[0]["bn"];
    if (is_numeric($bn)) {
      $ret = $bn + 1;
    }
  }
  $q->close();
  echo $ret;
