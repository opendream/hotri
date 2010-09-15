<?php
require_once('../classes/BiblioCoverQuery.php');
$cq = new BiblioCoverQuery();

$path = $cq->lookup($_GET['isbn']);
echo $path ? $path:$cq->getLookupError();
die();
