<?php
if (!isset($argv) || $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');

$s = file_get_contents(dirname(__FILE__) . "/cronrun.txt");
if (!eregi('ON', $s)) die($s); // Cron switch on/off.

$main_path = 'http://localhost/git_branches/odlib_lookup/hotri';
$s = file_get_contents($main_path . '/cron/lookup.php');


