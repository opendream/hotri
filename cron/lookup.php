<?php
if ($_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');
require_once(dirname(__FILE__) . "/../shared/common.php");
require_once(dirname(__FILE__) . '/../classes/BulkLookup.php');
// Process ISBN lookup
$limit = 10;
$q = new BulkLookupQuery();
$remain = $q->countQueue();

file_put_contents(dirname(__FILE__) . '/../cron/cronrun.txt', 'LOCK');

if ($remain < 1) {
  // Disable cron.
  file_put_contents(dirname(__FILE__) . '/../cron/cronrun.txt', 'OFF');
  die();
}
else {
  $q->getQueue('queue', $limit);
  while ($row = $q->fetch()) 
    $rows[] = $row;
  
  foreach ($rows as $row) {
    if ($row['tries'] < 3) {
      //$isbnList[] = $row['isbn'];
      $isbnList[] = array('isbn'=>$row['isbn'], 'amount'=>$row['amount']);
    }
    else {
      $q->setLookupStatus('manual', $row['isbn'], $row['amount']);
    }
  }

  $lookup = new BulkLookup();
  $lookup->search($isbnList);
}

file_put_contents(dirname(__FILE__) . '/../cron/cronrun.txt', 'ON');
