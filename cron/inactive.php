<?php
if ($_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) 
  die('Access denied.');

require_once("../classes/Iter.php");
require_once("../database_constants.php");
require_once("../classes/MemberQuery.php");

$mbrQ = new MemberQuery();
$mbrQ->connect();
$mbrQ->autoInactive();
