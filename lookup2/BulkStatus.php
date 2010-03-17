<?php
$tab = "admin";
$nav = "BulkLookup";
$helpPage = "BulkLookup";
$cancelLocation = "../admin/index.php";

require_once("../shared/common.php");
require_once("../shared/logincheck.php");

require_once('../classes/BulkLookup.php');
$q = new BulkLookupQuery();
$queued = $q->countQueue();
$done = $q->countQueue('publish');
$covered = $q->countQueue('cover');
$copied = $q->countQueue('copy');
$failed = $q->countQueue('manual');

if ($queued < 1) {
  echo "DONE";
}
echo "Last updated: " . date('Y-m-d H:i:s') . "<br />Remaining: $queued, done: " . ($done + $covered) . " ($covered covered), copied: $copied, failed: $failed";
if ($queued < 1) {
  echo '<h5 id="updateMsg">All items has been proceed!</h5> <br /><a href="BulkLookup.php">continue import</a> | <a href="../reports/bulk_report.php">view failed items</a><br /><br />';
  /*
  if ($failed > 0) {
    $q->getQueue('manual', $failed);
    echo "<h5>Failed ISBN:</h5>
Note: You should add below ones manually.<br />";
    for ($i = 0; $i < $failed; $i++) {
      $row = $q->fetch();
      if (!$row) break;
      echo $row['isbn'] . "<br />";
    }
  }
  */
}
?>
