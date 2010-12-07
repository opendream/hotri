<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  
  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  if (isset($_GET["tab"])) {
    $tab = $_GET["tab"];
  } else {
    $tab = "cataloging";
  }
  
  $isOpac = $tab == "opac";

  $nav = "view";
  if (!$isOpac) {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/Biblio.php");
  require_once("../classes/BiblioQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/UsmarcTagDm.php");
  require_once("../classes/UsmarcTagDmQuery.php");
  require_once("../classes/UsmarcSubfieldDm.php");
  require_once("../classes/UsmarcSubfieldDmQuery.php");
  require_once("../functions/marcFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");


  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $bibid = $_GET["bibid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  $collectionDm = $dmQ->getAssoc("collection_dm");
  $materialTypeDm = $dmQ->getAssoc("material_type_dm");
  $biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
  $dmQ->close();

  $marcTagDmQ = new UsmarcTagDmQuery();
  $marcTagDmQ->connect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTagDmQ->execSelect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTags = $marcTagDmQ->fetchRows();
  $marcTagDmQ->close();

  $marcSubfldDmQ = new UsmarcSubfieldDmQuery();
  $marcSubfldDmQ->connect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubfldDmQ->execSelect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubflds = $marcSubfldDmQ->fetchRows();
  $marcSubfldDmQ->close();


  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblio = $biblioQ->doQuery($bibid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $biblioFlds = $biblio->getBiblioFields();

  #**************************************************************************
  #*  Show bibliography info.
  #**************************************************************************
  if ($tab == "opac") {
    require_once("../shared/header_opac.php");
  } else {
    require_once("../shared/header.php");
  }

?>

<?php echo $msg ?>
<?php
// OpenURL support.
$doc_title = '';
$doc_author = '';
$doc_publisher = '';
$doc_pubplace = '';
$doc_pubyear = '';
$doc_isbn = '';

if (isset($biblioFlds["245a"])) 
  $doc_title = $biblioFlds["245a"]->getFieldData();
if (isset($biblioFlds["245b"])) 
  $doc_title .= ' : ' . $biblioFlds["245b"]->getFieldData();

$doc_title = trim($doc_title);

if (isset($biblioFlds["100a"])) 
  $doc_author = trim(str_replace('.', '', $biblioFlds["100a"]->getFieldData()));

if (isset($biblioFlds["260b"])) 
  $doc_publisher = trim(str_replace(array(':',',',';'), '', $biblioFlds["260b"]->getFieldData()));
if (isset($biblioFlds["260a"])) 
  $doc_pubplace = trim(str_replace(array(':',',',';'), '', $biblioFlds["260a"]->getFieldData()));
if (isset($biblioFlds["260c"])) 
  $doc_pubyear = trim(str_replace(array('c','.'), '', $biblioFlds["260c"]->getFieldData()));

if (isset($biblioFlds["020a"])) 
  $doc_isbn = trim($biblioFlds["020a"]->getFieldData());

// Edition
if (isset($biblioFlds["0822"])) 
  $doc_edition = trim($biblioFlds["0822"]->getFieldData());
  
// Short Title
if (isset($biblioFlds["247a"])) 
  $doc_stitle = trim($biblioFlds["247a"]->getFieldData());

if (strpos($doc_author, ',')) {
  $author_ex = explode(',', $doc_author);
  $doc_author_fname = trim($author_ex[1]);
  $doc_author_lname = trim($author_ex[0]);
}
else {
  $author_ex = explode(' ', $doc_author);
  $doc_author_fname = trim($author_ex[0]);
  $doc_author_lname = trim($author_ex[1]);
}

$Document->fields = array(
  'Id' => md5($bibid . $doc_title),
  'DocType' => 2, // Book, other types read in openUrl.php
  'DocTitle' => $doc_title,
  'JournalTitle' => false,
  'BookTitle' => $doc_title,
  'BookPublisher' => $doc_publisher,
  'PubPlace' => $doc_pubplace,
  'ISBN' => $doc_isbn,
  'StartPage' => false,
  'EndPage' => false,
  'DocYear' => $doc_pubyear,
  'DocEdition' => $doc_edition,
  'ShortTitle' => $doc_stitle,
);

$People[]->fields = array(
  'DocRelationship' => 0,
  'FirstName' => $doc_author_fname,
  'LastName' => $doc_author_lname,
);

$People[]->fields = array(
  'DocRelationship' => 0,
  'FirstName' => $doc_author_fname,
  'LastName' => $doc_author_lname,
);

require_once("../functions/openUrl.php");

?>
<span class="Z3988" title="<?php print OpenURL($Document, $People) ?>">OpenURL</span>
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble1Hdr"); ?>:
    </th>
  </tr>
  <tr>  
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewMaterialType"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewCollection"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo H($collectionDm[$biblio->getCollectionCd()]);?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("biblioViewCallNmbr"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php echo H($biblio->getCallNmbr1()); ?>
      <?php echo H($biblio->getCallNmbr2()); ?>
      <?php echo H($biblio->getCallNmbr3()); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(245,"a",$marcTags, $marcSubflds, FALSE, $isOpac);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245a"])) echo H($biblioFlds["245a"]->getFieldData());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(245,"b",$marcTags, $marcSubflds, FALSE, $isOpac);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245b"])) echo H($biblioFlds["245b"]->getFieldData());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php printUsmarcText(100,"a",$marcTags, $marcSubflds, FALSE, $isOpac);?>:
    </td>
    <td valign="top" class="primary">
      <?php 
      if (isset($biblioFlds["100a"])) {
        $val = H($biblioFlds["100a"]->getFieldData());
        echo '<a href="../shared/biblio_search.php?tag=100a&words=' . $val . '">' . $val . '</a>';
      }
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php printUsmarcText(245,"c",$marcTags, $marcSubflds, FALSE, $isOpac);?>:
    </td>
    <td valign="top" class="primary">
      <?php if (isset($biblioFlds["245c"])) echo H($biblioFlds["245c"]->getFieldData());?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioViewOpacFlg"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php if ($biblio->showInOpac()) {
        echo $loc->getText("biblioViewYes");
      } else {
        echo $loc->getText("biblioViewNo");
      }?>
    </td>
  </tr>
</table>
<br />

<?php
  #***************************************************************************
  #*  Show picture
  #***************************************************************************
  if (isset($biblioFlds["902a"])):
    $filepath = "../" . COVER_PATH . "/". $biblioFlds["902a"]->getFieldData();
    $title = H($biblioFlds["245a"]->getFieldData());
    //$info = _image_resize($filepath, 200);
    //if (is_array($info)): 
    if ($thumbpath = make_thumbnail($filepath, array('height' => 160))):
?>
<table class="primary">
  <tr>
    <th align="left" nowrap="yes">
      <strong><?php echo $loc->getText("biblioViewPictureHeader"); ?></strong>
    </td>
<?php
  if ($tab != "opac") {
?>
    <td align="right">
      <a href="../catalog/biblio_cover_del.php?bibid=<?php echo HURL($bibid);?>" onclick="javascript: return confirm('<?php echo htmlspecialchars($loc->getText('Are you sure to remove this picture?'), ENT_QUOTES); ?>');"><?php echo $loc->getText('Remove') ?></a>
    </td>
<?php
  }
?>
  </tr>
  <tr>
    <td valign="top" <?php echo $tab != "opac" ? 'colspan="2"' : ''; ?> class="primary">
      <a href="<?php echo $filepath ?>" title="<?php echo $title ?>" target="_blank"><img src="<?php echo $thumbpath ?>" border="0" title="<?php echo $title ?>" alt="<?php echo $title ?>" /></a>
    </td>
  </tr>
</table>
<?php
    endif;
  endif;
?>

<?php
  #****************************************************************************
  #*  Show copy information
  #****************************************************************************
  if ($tab == "cataloging") { ?>
    <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y">
      <?php echo $loc->getText("biblioViewNewCopy"); ?></a><br/>
    <?php
    $copyCols=7;
  } else {
    $copyCols=5;
  }

  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->execSelect($bibid)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
?>

<h1><?php echo $loc->getText("biblioViewTble2Hdr"); ?>:</h1>
<table class="primary">
  <tr>
    <?php if ($tab == "cataloging") { ?>
      <th colspan="2" nowrap="yes">
        <?php echo $loc->getText("biblioViewTble2ColFunc"); ?>
      </th>
    <?php } ?>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col1"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col2"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col3"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col4"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble2Col5"); ?>
    </th>
  </tr>
  <?php
    if ($copyQ->getRowCount() == 0) { ?>
      <tr>
        <td valign="top" colspan="<?php echo H($copyCols); ?>" class="primary" colspan="2">
          <?php echo $loc->getText("biblioViewNoCopies"); ?>
        </td>
      </tr>      
    <?php } else {
      $row_class = "primary";
      while ($copy = $copyQ->fetchCopy()) {
  ?>
    <tr>
      <?php if ($tab == "cataloging") { ?>
        <td valign="top" class="<?php echo H($row_class);?>">
          <a href="../catalog/biblio_copy_edit_form.php?bibid=<?php echo HURL($copy->getBibid());?>&amp;copyid=<?php echo H($copy->getCopyid());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("biblioViewTble2Coledit"); ?></a>
        </td>
        <td valign="top" class="<?php echo H($row_class);?>">
          <a href="../catalog/biblio_copy_del_confirm.php?bibid=<?php echo HURL($copy->getBibid());?>&amp;copyid=<?php echo HURL($copy->getCopyid());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("biblioViewTble2Coldel"); ?></a>
        </td>
      <?php } ?>
      <td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($copy->getBarcodeNmbr()); ?>
      </td>
      <td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($copy->getCopyDesc()); ?>
      </td>
      <td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($biblioStatusDm[$copy->getStatusCd()]); ?>
      </td>
      <td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($copy->getStatusBeginDt()); ?>
      </td>
      <td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($copy->getDueBackDt()); ?>
      </td>
    </tr>      
  <?php
        # swap row color
        if ($row_class == "primary") {
          $row_class = "alt1";
        } else {
          $row_class = "primary";
        }
      }
      $copyQ->close();
    } ?>
</table>





<br />
<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("biblioViewTble3Hdr"); ?>:
    </th>
  </tr>
  <?php
    $displayCount = 0;
    foreach ($biblioFlds as $key => $field) {
      if (($field->getFieldData() != "") 
        && ($key != "245a")
        && ($key != "245b")
        && ($key != "245c")
        && ($key != "100a")
        && ($key != "902a")) {
        $displayCount = $displayCount + 1;
  ?>
        <tr>
          <td valign="top" class="primary">
            <?php printUsmarcText($field->getTag(),$field->getSubfieldCd(),$marcTags, $marcSubflds, TRUE, $isOpac);?>:
          </td>
          <td valign="top" class="primary">
            <?php
            $val = H($field->getFieldData()); 
            if (in_array(substr($key, 0, 1), array('1', '4', '6', '7'))) {
              echo '<a href="../shared/biblio_search.php?tag=' . $key . '&words=' . $val . '">' . $val . '</a>';
            }
            else {
              echo $val;
            }
            ?>
          </td>
        </tr>      
  <?php
      }
    }
    if ($displayCount == 0) {
  ?>
        <tr>
          <td valign="top" class="primary" colspan="2">
            <?php echo $loc->getText("biblioViewNoAddInfo"); ?>
          </td>
        </tr>      
  <?php
    }
  ?>
</table>


<?php require_once("../shared/footer.php"); ?>
