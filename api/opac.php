<?php
require_once('../classes/BiblioApiQuery.php');

$api = new BiblioApiQuery();
/*
$api->search('test');
$api->getBiblio(20);
*/

if (!empty($_GET['keyword'])) {
  if (0 + $_GET['items'] > 0) 
    $items = 0 + $_GET['items'];
  else
    $items = 10;

  if (!empty($_GET['type']))
    $type = $_GET['type'];
  else
    $type = 'title';

  die($api->search($_GET['keyword'], 0 + $_GET['start'], $items, $type));
} 
else if (!empty($_GET['id']))
  die($api->getBiblio($_GET['id']));
else
  die();
?>
