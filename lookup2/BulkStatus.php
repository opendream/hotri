<?php
$tab = "admin";
$nav = "BulkLookup";
$helpPage = "BulkLookup";
$cancelLocation = "../admin/index.php";

require_once("../shared/common.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

require_once('../classes/BulkLookup.php');
$q = new BulkLookupQuery();
$queued = $q->countQueue();
$trying = $q->countQueue('queue_try');
$done = $q->countQueue('publish');
$covered = $q->countQueue('cover');
$copied = $q->countQueue('copy');
$failed = $q->countQueue('manual');
//$estimate_time = date('H:i:s', $q->getStartTime());
$est_time = $q->getStartTime();
$est_hour = str_pad(floor($est_time / 3600), 2, '0', STR_PAD_LEFT);
$est_min = str_pad(floor(($est_time % 3600) / 60), 2, '0', STR_PAD_LEFT);
$est_sec = str_pad(floor($est_time % 60), 2, '0', STR_PAD_LEFT);
$estimate_time = $est_hour . ':' . $est_min . ':' . $est_sec;
if ($queued < 1) {
  echo "DONE";
}
$cron_status = file_get_contents('../cron/cronrun.txt');

echo $loc->getText('lookup_bulkStatus', array(
  'updated' => date('Y-m-d H:i:s'),
  'estimate' => $estimate_time,
  'cron_status' => $cron_status,
  'remain' => $queued,
  'trying' => $trying,
  'done' => $done + $covered,
  'covered' => $covered,
  'copied' => $copied,
  'failed' => $failed,
));

if ($queued < 1) {
  echo '<h5 id="updateMsg">' . $loc->getText('lookup_bulkProceed') . '</h5> <br /><a href="BulkLookup.php">' . $loc->getText('lookup_bulkCont') . '</a> | <a href="../reports/bulk_report.php">' . $loc->getText('lookup_bulkViewFailed') . '</a><br /><br />';
}
?>
