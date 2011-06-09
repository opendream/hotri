<?php

  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");

  $tab = "cataloging";
  $nav = "bulk_delete";

  require_once("../shared/header.php");
  require_once("../functions/searchFuncs.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/Localize.php");

  $loc = new Localize(OBIB_LOCALE, $tab);
  $locsh = new Localize(OBIB_LOCALE, "shared");

  if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['action_delete'] == true) {
    $count = 0;
    foreach ($_POST as $k => $v) {
      if (strpos($k, "chk-") !== false) {
        $bib_id = substr($k, 4); // 'chk-123'
        $biblio = new BiblioQuery();
        $biblio->delete($bib_id);
        $count++;
      }
    }

    echo '<div id="message"><font class="error">';
    if ($count == 1) {
      echo $count .' '. $locsh->getText("sharedRecordIsDeleted");
    } elseif ($count > 1) {
      echo $count .' '. $locsh->getText("sharedRecordsAreDeleted");
    }
    echo '</font></div>';
  }

  $dmQ = new DmQuery();
  $dmQ->connect();
  $collectionDm = $dmQ->getAssoc("collection_dm");
  $materialTypeDm = $dmQ->getAssoc("material_type_dm");
  $dmQ->close();

  $biblioQ = new BiblioSearchQuery();
  $biblioQ->setItemsPerPage(50);
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  $sType = 'title';
  $words = '';
  $currentPageNmbr = isset($_POST["page"]) ? $_POST["page"] : 1;
  $sortBy = 'title';
  $opacFlg = false;
  if (!$biblioQ->search($sType, $words, $currentPageNmbr, $sortBy, $opacFlg)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  if ($biblioQ->getRowCount() == 0) { // IFELSE 1
    $biblioQ->close();
    echo $loc->getText("biblioSearchNoResults");
    require_once("../shared/footer.php");
    exit();
  } else {
?>

  <script type="text/javascript">
    function changePage(page,sort) {
      document.changePageForm.page.value = page;
      document.changePageForm.sortBy.value = sort;
      document.changePageForm.submit();
    }
  </script>

  <form name="changePageForm" method="POST" action="../catalog/biblio_bulk_delete.php">
    <input type="hidden" name="searchType" value="<?php echo $sType ?>" />
    <input type="hidden" name="searchText" value="" />
    <input type="hidden" name="sortBy" value="<?php echo $sort ?>" />
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="tab" value="<?php echo H($tab); ?>" />
  </form>

  <form method="POST">
  <div id="form-select-biblio">
  <table class="primary">
    <tr>
      <th>&nbsp;</th>
      <th><?php echo $locsh->getText("biblioSearchTitle"); ?></th>
      <th><?php echo $locsh->getText("biblioSearchAuthor"); ?></th>
      <th><?php echo $locsh->getText("biblioSearchMaterial"); ?></th>
      <th><?php echo $locsh->getText("biblioSearchCollection"); ?></th>
    </tr>
<?php
    while ($biblio = $biblioQ->_conn->fetchRow()) {
?>
    <tr>
      <td><input type="checkbox" name="chk-<?php echo $biblio['bibid']; ?>" /></td>
      <td>
        <a href="<?php echo DOCUMENT_ROOT; ?>shared/biblio_view.php?bibid=<?php echo $biblio['bibid']; ?>"><?php echo $biblio['title']; ?></a>
      </td>
      <td>
        <?php echo $biblio['author']; ?>
      </td>
      <td>
        <?php echo H($materialTypeDm[$biblio['material_cd']]); ?>
      </td>
      <td>
        <?php echo H($collectionDm[$biblio['collection_cd']]); ?>
      </td>
    </tr>
<?php
    } // END WHILE
?>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr>
      <td colspan="5">
        <input type="button" value="<?php echo $locsh->getText("sharedDelete"); ?>" class="button" id="biblio-bulk-delete" />
      </td>
    </tr>
  </table>
  </div>

  <div id="form-confirm" style="display:none;">
    <h3><?php echo $locsh->getText("sharedListOfDeletedItems"); ?></h3>
    <ul id="list-deleted-items"></ul>
    <div><?php echo $locsh->getText("sharedDeleteWarning"); ?></div>
    <input type="hidden" name="action_delete" value="true" />
    <input type="submit" value="<?php echo $locsh->getText("sharedComfirmDelete"); ?>" class="button" />
    <?php echo $locsh->getText("or"); ?>
    <a href="<?php echo DOCUMENT_ROOT; ?>catalog/biblio_bulk_delete.php"><?php echo $locsh->getText("cancel"); ?></a>
  </div>
  </form>
<?php
  } // END IFELSE 1

  function printResultPages(&$loc, $currPage, $pageCount, $sort) {
    if ($pageCount <= 1) {
      return false;
    }
    echo $loc->getText("biblioSearchResultPages").": ";
    $maxPg = OBIB_SEARCH_MAXPAGES;
    if ($maxPg % 2 == 0) $maxPg++;
    $borderPg = ($maxPg - 1) / 2;
    
    if ($maxPg > $pageCount) {
      $startPg = 1;
      $endPg = $pageCount;
    }
    else {
      if ($currPage - $borderPg < 1) {
        $startPg = 1;
        $endPg = $maxPg;
      }
      elseif ($currPage + $borderPg > $pageCount) {
        $endPg = $pageCount;
        $startPg = $endPg - $maxPg + 1;
      }
      else {
        $startPg = $currPage - $borderPg;
        $endPg = $currPage + $borderPg;
      }
    }

    if ($currPage > 1) {
      echo "<a href=\"javascript:changePage(1,'".H(addslashes($sort))."')\">&laquo;".$loc->getText("biblioSearchFirst")."</a> ";
      echo "<a href=\"javascript:changePage(".H(addslashes($currPage-1)).",'".H(addslashes($sort))."')\">&lsaquo;".$loc->getText("biblioSearchPrev")."</a> ";
    }
    for ($i = $startPg; $i <= $endPg; $i++) {
      if ($i == $currPage) {
        echo "<b>".H($i)."</b> ";
      } else {
        echo "<a href=\"javascript:changePage(".H(addslashes($i)).",'".H(addslashes($sort))."')\">".H($i)."</a> ";
      }
    }
    if ($currPage < $pageCount) {
      echo "<a href=\"javascript:changePage(".($currPage+1).",'".$sort."')\">".$loc->getText("biblioSearchNext")."&rsaquo;</a> ";
      echo "<a href=\"javascript:changePage(".$pageCount.",'".$sort."')\">".$loc->getText("biblioSearchLast")."&raquo;</a> ";
    }
  }

  echo "<div id=\"pagination\">"; 
  printResultPages($locsh, $currentPageNmbr, $biblioQ->getPageCount(), $sortBy);
  echo "</div>"; 

  include("../shared/footer.php");
