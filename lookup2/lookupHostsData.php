<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  require_once(REL(__FILE__, "../shared/logincheck.php"));
  require_once(REL(__FILE__, "../functions/errorFuncs.php"));

  require_once(REL(__FILE__, "LookupHosts.php"));
	require_once(REL(__FILE__, 'LookupHostsQuery.php'));

switch ($_REQUEST[mode]){
  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'getHosts':
		## prepare list of hosts using LookupHost
		getHosts('all'); # results are in $postVars[hosts] & $postVars[numHosts]
		echo json_encode($postVars[hosts]);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'addNew':
		## add new host database entry
		echo insertHost($_POST);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'update':
		## update host database entry
		echo updateHost($_POST);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'd-3-L-3-t':
		## delete host database entry
		echo deleteHost($_GET);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	default:
	  echo "<h4>invalid mode: $_REQUEST[mode]</h4><br />";
	break;
}

/*
  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["reset"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    include_once("../lookup2/LookupHosts.php");
    include_once("../lookup2/LookupHostsQuery.php");
    include_once("../functions/errorFuncs.php");
    $setQ = new LookupHostQuery();
    $setQ->connect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $setQ->execSelect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $set = $setQ->fetchRow();
    $postVars["seq"] = $set->getSeq();
    if ($set->getActive()) {
      $postVars["active"] = "CHECKED";
    } else {
      $postVars["active"] = "";
    }
    $postVars["host"] = $set->getHost();
    $postVars["name"] = $set->getName();
    $postVars["db"] = $set->getDb();
    $postVars["user"] = $set->getUser();
    $postVars["pw"] = $set->getPw();
    $setQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }
  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../lookup2/lookupHostsForm.php?reset=Y");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $set = new LookupHosts();

  $set->setSeq($_POST["seq"]);
  $_POST["seq"] = $set->getSeq();

  $set->setActive($_POST["active"]);
  $_POST["active"] = $set->getActive();

  $set->setHost($_POST["host"]);
  $_POST["host"] = $set->getHost();

  $set->setName($_POST["name"]);
  $_POST["name"] = $set->getName();

  $set->setDb($_POST["db"]);
  $_POST["db"] = $set->getDb();

  $set->setUser($_POST["user"]);
  $_POST["user"] = $set->getUser();

  $set->setPw($_POST["pw"]);
  $_POST["pw"] = $set->getPw();

  if (!$set->validateData()) {
    //$pageErrors["sessionTimeout"] = $set->getSessionTimeoutError();
    //$pageErrors["itemsPerPage"] = $set->getItemsPerPageError();
    //$pageErrors["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonthsError();
    $_SESSION["postVars"] = $_POST;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../admin/lookupHostForm.php");
    exit();
  }

  #**************************************************************************
  #*  Update domain table row
  #**************************************************************************
  $setQ = new LookupHostQuery();
  $setQ->connect();
  if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  if (!$setQ->update($set)) {
    $setQ->close();
    displayErrorPage($setQ);
  }
  $setQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  header("Location: ../admin/lookup_edit_form.php?reset=Y&updated=Y");
  exit();
*/
?>
