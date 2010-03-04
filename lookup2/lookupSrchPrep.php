<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

		# prepare user search criteria
		require_once(REL(__FILE__, 'lookupSrchVals.php'));
		
		$ttlHits = 0;
		$numHosts = $postVars[numHosts];
		//print("trying $numHosts host(s)<br />");

	   if ($postVars[protocol] == 'YAZ') {
			//print("using YAZ protocol<br />");
			require_once (REL(__FILE__, 'lookupYazSrch.php'));
		} else if ($postVars[protocol] == 'SRU') {
			//print("using SRU protocol<br />");
			require_once (REL(__FILE__, 'lookupSruSrch.php'));
		} else {
			echo "Invalid protocol specified.<br />";
		}
/*
		##=========================
		## following patch from Christoph Lange of Germany
		##=========================
		//	if ($srchBy == "7") $ttlHits = 1;	// searched by ISBN
		##=========================
*/
		$initialCond = false;

		//echo "ttl hits= $ttlHits<br />";
		## TOO FEW
		if ($ttlHits == 0) {
		  $msg1 = $lookLoc->getText('lookup_nothingFound');
		  # JSON object follows
		  $s =  "{'ttlHits':'0','maxHits':'$postVars[maxHits]','protocol':'$postVars[protocol]',".
						"'msg':'$msg1',".
						"'srch1':{'byName':'$srchByName','lookupVal':'$lookupVal'},".
						"'srch2':{'byName':'$srchByName2','lookupVal':'$lookupVal2'}".
					  "}";
		}
		## NO RESPONSE
		else if (empty($ttlHits)) {
		  $msg1 = $lookLoc->getText('lookup_noResponse');
		  $msg2 = $lookLoc->getText('lookup_checkHostSpecifications');
			 # JSON object follows
		  $s =  "{'ttlHits':'none','maxHits':'$postVars[maxHits]','protocol':'$postVars[protocol]',".
						"'msg':'$msg1', 'msg2':'$msg2' ".
						"}";
		}
		## TOO MANY
		else if ($ttlHits > $postVars[maxHits]) {
			$msg1 = $lookLoc->getText('lookup_TooManyHits');
			$msg2 = $lookLoc->getText('lookup_RefineSearch');
			 # JSON object follows
		  $s =  "{'ttlHits':'$ttlHits','maxHits':'$postVars[maxHits]','protocol':'$postVars[protocol]',".
						"'msg':'$msg1', 'msg2':'$msg2' ".
						"}";
		}
		## GOOD COUNT
		else if ($ttlHits > 0) {
			if ($numHosts > 0) {
				$postit = true;
				$_POST['ttlHits'] = $ttlHits;
				$_POST['numHosts'] = $numHosts;
//				$_POST['postVars'] = $postVars; // for debugging
				$rslt = array();
				for ($h=0; $h<$numHosts; $h++) {
					if ($postVars[protocol] == 'YAZ') {
						$rslt[$h] = doOneHost($h, $hits, $id); // build an array of host data
					}
					else if ($postVars[protocol] == 'SRU'){
					  $rslt[$h] = $marc[$h];
					}
					//	$lookupVal = "";
					//	$srchBy = "";
				}
				$_POST[data] = $rslt;
			}
			$s = json_encode($_POST);
	}
  echo $s;

	error_reporting($err_level);		## restore original value
	set_error_handler($err_fnctn);	## restore original handler
?>
