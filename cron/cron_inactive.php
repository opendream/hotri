<?php
if (!isset($argv))
  die('Access denied.');

require_once(dirname(__FILE__) . "/../shared/global_constants.php");
require_once(dirname(__FILE__) . '/../classes/Iter.php');
require_once(dirname(__FILE__) . "/../database_constants.php");
require_once(dirname(__FILE__) . '/../classes/Query.php');
include(dirname(__FILE__) . '/../classes/CronQuery.php');
$cronQ = new CronQuery();
$path = implode('/', explode('/', $cronQ->getUrlPath(), -1));
$s = file_get_contents($path . '/inactive.php');
