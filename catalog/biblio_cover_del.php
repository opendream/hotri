<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "view";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  $bibid = 0 + $_GET["bibid"];

  require_once("../classes/BiblioQuery.php");
  
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
  
  // get image path
  $imgname = $biblio->_biblioFields['902a']->_fieldData;
  $imgpath =  '../' . COVER_PATH . '/' . $imgname;
  $thumbpath =  '../' . COVER_PATH . '/' . 'thumb_' . $imgname;
  
  if (file_exists($imgpath)) {
    chmod($imgpath, 666); // Windows platform compatibility, 666 is for "Nobody"
    unlink($imgpath); 
  }
  
  if (file_exists($thumbpath)) {
    chmod($thumbpath, 666);
    unlink($thumbpath); 
  }
  
  if (!$biblioQ->deleteCoverImage($bibid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  
  $biblioQ->close();
  
  if ($_GET['redirect'] == 'edit') {
    header("Location: ../catalog/biblio_edit.php?bibid=" . U($bibid)."&msg=".U($loc->gettext("This biblio's cover image has been removed.")));
  }
  else {
    header('Location: ../shared/biblio_view.php?bibid=' . U($bibid)."&msg=".U($loc->gettext("This biblio's cover image has been removed.")));
  }
  
