<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
require_once(REL(__FILE__, "../classes/Localize.php"));

include_once(REL(__FILE__, "../functions/errorFuncs.php"));
include_once(REL(__FILE__, "../classes/Iter.php"));
require_once(REL(__FILE__, 'lookupFunc.php'));	## general support functions

## prepare for UI string translations
$lookLoc = new Localize(OBIB_LOCALE,'cataloging');

## fetch user options and post to $postVars
require_once(REL(__FILE__, "LookupOptsQuery.php"));
getOpts();

  #****************************************************************************
  #*  Additional initialization activity
  #****************************************************************************

	## get default collection name
	class myQuery extends Query {
	  function getDefault() {
   		$sql = "SELECT * FROM `collection_dm` ".
						 " WHERE `default_flg`='Y' ";
			//echo "sql=$sql <br />";
   		return $this->select01($sql);
		}
	}
 	$Q = new myQuery();
 	$Q->connect();
 	$s = $Q->getDefault();
 	$Q->close();
	//print_r($s);
 	//$postVars['defaultCollect'] = $s['description'];
 	$postVars['defaultCollect'] = $s['code'];

	## set protocol flag
	if ($postVars[protocol] == 'YAZ') {
		//echo " want to use YAZ protocol <br />";
	  $useYAZ = true;
	  $useSRU = false;
	}
	else if ($postVars[protocol] == 'SRU'){
		//echo " want to use SRU protocol <br />";
	  $useSRU = true;
	  $useYAZ = false;
	} else {
		echo "invalid protocol '$postVars[protocol]' specified.";
	}

	## set cutter type flag
	if ($postVars[cutterType] == 'LoC') {
		require_once('lookupCutterLoc.php');
	}
	elseif ($postVars[cutterType] == 'CS3') {
		require_once('lookupCutterCs3.php');
	}
	else {
		echo "Invalid cutter type selection - '$postVars[cutterType]'. <br />";
	}

## prepare list of hosts using LookupHost
require_once(REL(__FILE__, 'LookupHostsQuery.php'));
getHosts(''); # results are in $postVars[hosts] & $postVars[numHosts]

## main body of code
switch ($_REQUEST[mode]){
  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'getHosts':
		echo json_encode($postVars[hosts]);
		//echo json_encode($postVars);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'getCutter':
		echo "{'cutter':'".getCutter($_REQUEST[author])."'}";
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'getOpts':
		echo json_encode($postVars);
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'search':
		include('lookupSrchPrep.php'); ## will respond directly, depending on what is received
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	case 'abandon':
		for ($n=0; $n<$postVars[numHosts]; $n++) {
			yaz_close($id[$n]);
		}
	break;

  #-.-.-.-.-.-.-.-.-.-.-.-.-
	default:
	  echo "invalid mode: $_POST[mode] <br />";
	break;
}

?>
