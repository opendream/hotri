<?php
$tab = "reports";
if ($_GET['type'] == 'manual') 
  $nav = "BulkLookupManual";
else if ($_GET['type'] == 'cover')
  $nav = "BulkLookupCover";
else
  $nav = "BulkLookup";

$cancelLocation = "../admin/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);
$navLoc = new Localize(OBIB_LOCALE, 'navbars');

require_once("../classes/BulkLookup.php");

if (!($_GET['type'] == 'manual' && $_GET['act'] == "export")) 
require_once("../shared/header.php");

switch ($_GET['type']) {
  case 'cover':
?>
<h1><?php echo $navLoc->getText('reportsNoCover'); ?></h1>
<table class="primary" border="1" cellpadding="3">
<th><?php echo $loc->getText('bulkReportBibID'); ?></th><th><?php echo $loc->getText('bulkReportBibName'); ?></th><th><?php echo $loc->getText('function'); ?></th></tr>
<?php
$bl = new BulkLookupQuery();

// Paging
$total = $bl->countQueue('cover_list');
$limit = 50;
if (0 + $_GET['page'] < 1 || ($p-1) * $limit >= $total) $p = 1;
else $p = 0 + $_GET['page'];
$bl->getNoCoverList($limit, ($p-1) * $limit);

$rows = array();
while ($row = $bl->fetch()) {
  $rows[] = $row;
}
if (count($rows) < 1) {
  echo "<tr><td colspan=\"7\" class=\"primary\">" . $loc->getText('bulkReportAllCovered') . "</td></tr>";
}

foreach ($rows as $row) {
  echo "<tr>".
       "  <td class=\"primary center\">{$row['bibid']}</td>".
       "  <td class=\"primary\">{$row['title']}</td>".
       "  <td class=\"primary\">".
       "    <a href=\"../catalog/biblio_edit.php?bibid={$row['bibid']}\">" . $loc->getText('edit') . "</a>".
       "  </td>".
       "</tr>";
}
?>
</table>
<?php
// Paging link
if ($p > 1) $prev = "<a href=\"?type=cover&page=".($p-1)."\">Previous</a>";
if ($p * $limit < $total) $next = "<a href=\"?type=cover&page=".($p+1)."\">Next</a>";

echo $prev . ($prev && $next ? ' | ' : '') . $next;
?>

<?php
    break;
  case 'manual':
    if ($_GET['act'] == 'cleartemp') {
      $bl = new BulkLookupQuery();
      $bl->clearDoneQueue('manual_list');
      $msg = '<h5 id="updateMsg">' . $loc->getText('bulkReportZeroHitsClear') . '</h5>';
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
        $msg = '<h5 id="updateMsg">' . $loc->getText('bulkReportPurgeDone') . '</h5>';
      else 
        $msg = '<h5 id="updateMsg">' . $loc->getText('bulkReportISBNRemoved', array('isbn' => $isbn)) . '</h5>';
    }
  default:
?>
<h1><?php echo $navLoc->getText('reportsFailedImport'); ?></h1>
<?php print $msg ?>
<table class="primary" border="1" cellpadding="3">
<th>ISBN</th><th><?php echo $loc->getText('Hits'); ?></th><th><?php echo $loc->getText('Created'); ?></th><th colspan="3"><?php echo $loc->getText('function'); ?></th><th><?php echo $loc->getText('OPAC') ?></th></tr>
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
  echo "<tr><td colspan=\"7\" class=\"primary\">" . $loc->getText('bulkReportNoItem') . "</td></tr>";
}

foreach ($rows as $row) {
  $bibid = $bl->getExistBiblio($row['isbn']);
  $status = $bibid > 0 ? "yes":"no";
  echo "<tr>".
       "  <td class=\"primary\">{$row['isbn']}</td>".
       "  <td class=\"primary center\">{$row['hits']}</td>".
       "  <td class=\"primary\">{$row['created']}</td>".
       "  <td class=\"primary\"><a href=\"../catalog/biblio_new.php?isbn={$row['isbn']}&hits={$row['hits']}\">" . $loc->getText('add') . "</a></td>".
       "  <td class=\"primary\">".
       "    <a href=\"?del={$row['isbn']}&type=manual\" onclick=\"return confirm('" . $loc->getText('bulkReportConfirmRemoveISBN', array('isbn' => $row['isbn'])) . "')\">" . $loc->getText ('remove') . "</a>".
       "  </td>".
       ($bibid < 1 ?
       "  <td class=\"primary\">&nbsp;</td>" :
       "  <td class=\"primary\">".
       "    <a href=\"../catalog/biblio_copy_new_form.php?bibid={$bibid}&isbn={$row['isbn']}&hits={$row['hits']}\">copy</a>".
       "  </td>") .
       "  <td class=\"primary\">$status</td>".
       "</tr>";
}
?>
</table>

<?php
// Paging link
if ($p > 1) $prev = "<a href=\"?type=manual&page=".($p-1)."\">Previous</a>";
if ($p * $limit < $total) $next = "<a href=\"?type=manual&page=".($p+1)."\">Next</a>";

echo $prev . ($prev && $next ? ' | ' : '') . $next;
echo '<p><a href="?type=manual&act=export">' . $loc->getText('Export to file') . '</a> | <a href="?del=0&type=manual" onclick="return confirm(\'' . $loc->getText('bulkReportConfirmPurge') . '\')">' . $loc->getText('Purge all items') . '</a></p>';
  $zero_hits = $bl->countQueue('manual_list_zero');
  if ($zero_hits > 0) {
    echo '<p><span class="warn" style="color:red">*</span> ' . $loc->getText('bulkReportZeroHits', array('zero_hits' => $zero_hits)) . '</p>';
  }
  break;
}

include("../shared/footer.php");
