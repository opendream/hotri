<?php
if ($_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');
require_once(dirname(__FILE__) . "/../shared/common.php");
require_once(dirname(__FILE__) . '/../lookup2/BulkLookup.class.php');
// Process ISBN lookup
$limit = 30;
$q = new BulkLookupQuery();
$remain = $q->countQueue();
$q->getQueue('queue', $limit);

for ($i = 0; $i < $remain && $i < $limit; $i++) {
  $row = $q->fetch();
  if ($row['tries'] < 3) {
    $isbnList[] = $row['isbn'];
  }
  else {
    $q->setLookupStatus('manual', $row['isbn']);
  }
}

$lookup = new BulkLookup();
$lookup->search($isbnList);
