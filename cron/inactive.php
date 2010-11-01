<?php
if (!isset($argv) || $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');

ini_set('include_path', __FILE__ . '/');
require_once("../classes/Iter.php");
require_once("../database_constants.php");
require_once("../classes/MemberQuery.php");

$mbrQ = new MemberQuery();
$mbrQ->connect();
$mbrQ->autoInactive();
