<?php
if (!isset($argv) || $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');

$s = file_get_contents(dirname(__FILE__) . "/cronrun.txt");
if (!eregi('ON', $s)) die($s); // Cron switch on/off.

require_once(dirname(__FILE__) . '/../classes/Iter.php');
require_once(dirname(__FILE__) . "/../database_constants.php");
require_once(dirname(__FILE__) . '/../classes/Query.php');
include(dirname(__FILE__) . '/../classes/CronQuery.php');
$cronQ = new CronQuery();
$s = file_get_contents($cronQ->getUrlPath());


