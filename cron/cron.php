<?php
if (!isset($argv) || $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');

$s = file_get_contents(dirname(__FILE__) . '/cronrun.txt');
if (!eregi('ON', $s)) die($s); // Cron switch on/off.

$s = file_get_contents('http://localhost/git_branches/odlib/hotri' . '/cron/lookup.php');


