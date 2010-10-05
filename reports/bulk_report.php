<?php
$tab = "reports";
if ($_GET['type'] == 'manual') 
  $nav = "BulkLookupManual";
else if ($_GET['type'] == 'cover')
  $nav = "BulkLookupCover";
else
  $nav = "BulkLookup";

$helpPage = "BulkLookup";
$cancelLocation = "../admin/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");

require_once("../classes/BulkLookup.php");

if (!($_GET['type'] == 'manual' && $_GET['act'] == "export")) 
require_once("../shared/header.php");

switch ($_GET['type']) {
  case 'cover':
?>
<h1>No-Cover Items</h1>
<table class="primary" border="1" cellpadding="3">
<th>BibID</th><th>Name</th><th>Actions</th></tr>
<?php
$bl = new BulkLookupQuery();

// Paging
$limit = 50;
if (0 + $_GET['page'] < 1 || ($p-1) * $limit >= $total) $p = 1;
else $p = 0 + $_GET['page'];
$bl->getNoCoverList($limit, ($p-1) * $limit);

$rows = array();
while ($row = $bl->fetch()) {
  $rows[] = $row;
}
if (count($rows) < 1) {
  echo "<tr><td colspan=\"7\">All items have their book cover.</td></tr>";
}

foreach ($rows as $row) {
  echo "<tr><td>{$row['bibid']}</td><td>{$row['title']}</td>" .
   "<td><a href=\"../catalog/biblio_edit.php?bibid={$row['bibid']}\">Edit</a></td>" .
   "</tr>";
}
?>
</table>
<?php
// Paging link
$total = $bl->countQueue('cover_list');
if ($p > 1) $prev = "<a href=\"?type=cover&page=".($p-1)."\">Previous</a>";
if ($p * $limit < $total) $next = "<a href=\"?type=cover&page=".($p+1)."\">Next</a>";

echo $prev . ($prev && $next ? ' | ' : '') . $next;
?>
<?
    break;
  case 'manual':
    if ($_GET['act'] == 'cleartemp') {
      $bl = new BulkLookupQuery();
      $bl->clearDoneQueue('manual_list');
      $msg = '<h5 id="updateMsg">Hidden items (no copy) has been removed from failed list.</h5>';
    }
    else if ($_GET['act'] == 'export') {
      $bl = new BulkLookupQuery();
      $total = $bl->countQueue('manual_list');
      $bl->getManualList($total);
      while ($row = $bl->fetch()) {
        for ($i = 0; $i < $row['hits']; $i++) 
          $f .= $row['isbn'] . "\n";
      }
      header("Content-Type: plain/text");
      header("Content-Disposition: attachment; filename=isbn_export_".date('Ymd_his').".txt");
      header("Content-Length: " . strlen($f));
      die($f);
    }

    if (isset($_GET['del'])) { // Action: del
      $isbn = $_GET['del'];
      $bl = new BulkLookupQuery();
      $bl->removeManualItem($isbn);
      if (empty($_GET['del']))
        $msg = '<h5 id="updateMsg">All items has been purged from failed list.</h5>';
      else 
        $msg = '<h5 id="updateMsg">ISBN ' . $isbn . ' has been removed from failed list.</h5>';
    }
  default:
?>
<h1>Failed Imports</h1>
<?php print $msg ?>
<table class="primary" border="1" cellpadding="3">
<th>ISBN</th><th>Hits</th><th>Created</th><th colspan="3">Actions</th><th>Exist in catalog?</th></tr>
<?php
$bl = new BulkLookupQuery();

// Paging
$limit = 50;
$total = $bl->countQueue('manual_list');
if (0 + $_GET['page'] < 1 || ($p-1) * $limit >= $total) $p = 1;
else $p = 0 + $_GET['page'];
$bl->getManualList($limit, ($p-1) * $limit);

$rows = array();
while ($row = $bl->fetch()) {
  $rows[] = $row;
}
if (count($rows) < 1) {
  echo "<tr><td colspan=\"7\">No failed items yet.</td></tr>";
}

foreach ($rows as $row) {
  $bibid = $bl->getExistBiblio($row['isbn']);
  $status = $bibid > 0 ? "yes":"no";
  echo "<tr><td>{$row['isbn']}</td><td>{$row['hits']}</td><td>{$row['created']}</td><td><a href=\"../catalog/biblio_new.php?isbn={$row['isbn']}&hits={$row['hits']}\">add</a></td>" .
   "<td><a href=\"?del={$row['isbn']}&type=manual\" onclick=\"return confirm('Are you sure to remove ISBN: {$row['isbn']}?')\">remove</a></td>" .
   ($bibid < 1 ? "<td>&nbsp;</td>":"<td><a href=\"../catalog/biblio_copy_new_form.php?bibid={$bibid}&isbn={$row['isbn']}&hits={$row['hits']}\">copy</a></td>") . 
   "<td>$status</td></tr>";
}
?>
</table>
<?php
// Paging link
if ($p > 1) $prev = "<a href=\"?type=manual&page=".($p-1)."\">Previous</a>";
if ($p * $limit < $total) $next = "<a href=\"?type=manual&page=".($p+1)."\">Next</a>";

echo $prev . ($prev && $next ? ' | ' : '') . $next;
echo '<p><a href="?type=manual&act=export">Export to file</a> | <a href="?del=0&type=manual" onclick="return confirm(\'Are you sure to purge ISBN list?\')">Purge all items</a></p>';
  $zero_hits = $bl->countQueue('manual_list_zero');
  if ($zero_hits > 0) {
    echo '<p><span class="warn" style="color:red">*</span> Found ' . $zero_hits . ' hidden items (nothing copy), <a href="bulk_report.php?type=manual&act=cleartemp">clear now.</a></p>';
  }
  break;
}

include("../shared/footer.php");
