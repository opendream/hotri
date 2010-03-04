<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  require_once("../shared/common.php");
  require_once(REL(__FILE__, "../functions/errorFuncs.php"));

  require_once(REL(__FILE__, "LookupOpts.php"));
  require_once(REL(__FILE__, "LookupOptsQuery.php"));
  
	switch ($_REQUEST[mode]){
	  #-.-.-.-.-.-.-.-.-.-.-.-.-
		case 'getOpts':
			getOpts(); 
			echo json_encode($postVars);
		break;

	  #-.-.-.-.-.-.-.-.-.-.-.-.-
		case 'update':
			echo updateOpts($_POST);
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

    include_once("../classes/LookupOpts.php");
    include_once("../classes/LookupQuery.php");
    include_once("../functions/errorFuncs.php");
    $setQ = new LookupQuery();
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
    $postVars["protocol"] = $set->getProtocol();
    $postVars["maxHits"] = $set->getMaxHits();
    if ($set->getKeepDashes()) {
      $postVars["keepDashes"] = "CHECKED";
    } else {
      $postVars["keepDashes"] = "";
    }
    $postVars["callNmbrType"] = $set->getCallNmbrtype();
    if ($set->getAutoDewey()) {
      $postVars["autoDewey"] = "CHECKED";
    } else {
      $postVars["autoDewey"] = "";
    }
    $postVars["defaultDewey"] = $set->getDefaultDewey();
     if ($set->getAutoCutter()) {
      $postVars["autoCutter"] = "CHECKED";
    } else {
      $postVars["autoCutter"] = "";
    }
    $postVars["cutterType"] = $set->getCutterType();
    $postVars["cutterWord"] = $set->getCutterWord();
    if ($set->getAutoCollect()) {
      $postVars["autoCollect"] = "CHECKED";
    } else {
      $postVars["autoCollect"] = "";
    }
    $postVars["fictionName"] = $set->getFictionName();
    $postVars["fictionCode"] = $set->getFictioncode();
    $postVars["fictionLoC"] = $set->getFictionLoC();
    $postVars["fictionDew"] = $set->getFictionDew();
    $setQ->close();
  } else {
    require(REL(__FILE__, "../shared/get_form_vars.php"));
  }
*/
?>
