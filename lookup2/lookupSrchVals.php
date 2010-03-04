<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

	## collect data from a search submittal
	$srchBy =			$_REQUEST[srchBy];
	$lookupVal =	$_REQUEST[lookupVal];
	$srchBy2 =		$_REQUEST[srchBy2];
	$lookupVal2 =	$_REQUEST[lookupVal2];
	$srchBy3 =		$_REQUEST[srchBy3];
	$lookupVal3 =	$_REQUEST[lookupVal3];
	$srchBy4 =		$_REQUEST[srchBy4];
	$lookupVal4 =	$_REQUEST[lookupVal4];
	$srchBy5 =		$_REQUEST[srchBy5];
	$lookupVal5 =	$_REQUEST[lookupVal5];

		//echo 'original Query specification is: ' . htmlspecialchars("#$srchBy => $lookupVal") . '<br />';
		//echo 'srchBy: ' . $srchBy . ', srchBy2: ' . $srchBy2 . '<br />';
		#### First search criteria line
		switch($srchBy) {
		case "4":
			$srchByName = 'Title ';
			$sruQry = 'dc.title=';
			$lookupVal = '"' . $lookupVal . '"';
			break;

		case "7":
			$srchByName = 'ISBN';
			$sruQry = 'dc.identifier=/bib.identifierAuthority=isbn ';
			$lookupVal = verifyISBN($lookupVal,$keepIsbnDashes);
		   break;

		case "8":
			$srchByName = 'ISSN';
			$sruQry = 'dc.identifier=/bib.identifierAuthority=issn ';
			//protocol requires that '-' be included in ISSN searches
			break;

		case "9":
			$srchByName = 'LCCN';
			$sruQry = 'dc.identifier=/bib.identifierAuthority=lccn ';
			//echo "input lccn=$lookupVal <br />";
			$lookupVal = verifyLCCN($lookupVal,$keepIsbnDashes);
			//echo 'final lccn: ' . $lookupVal . '<br />';
		   break;

		case "1016":
		  $srchByName = 'Keyword';
			$sruQry = 'dc.subject=';
			$lookupVal = '"' . $lookupVal . '"';
			break;
		}

		#### Second search criteria line
		if (!empty($lookupVal2)) {
			if ($srchBy2 == "1004") {
				$srchByName2 = 'Author';
				$sruQry2 = 'bib.NamePersonal=/bib.role=author/bib.roleAuthority=marcrelator ';
			}	else if ($srchBy2 == "1016") {
				$srchByName2 = 'Keyword';
				$sruQry2 = 'dc.subject=';
  		}
			$lookupVal2 = '"' . $lookupVal2 . '"';
		}
		
		#### Third search criteria line
		if (!empty($lookupVal3)) {
			if ($srchBy3 == "1018") {
				$srchByName3 = 'Publisher';
				$sruQry3 = 'dc.publisher=';
			}	else if ($srchBy3 == "59") {
				$srchByName3 = 'Pub Loc';
				$sruQry3 = 'bib.originPlace=/bib.portion=city ';
			}	else if ($srchBy3 == "31") {
				$srchByName3 = 'Pub Date';
				$sruQry3 = 'dc.date=';
			}	else if ($srchBy3 == "1016") {
				$srchByName3 = 'Keyword';
				$sruQry3 = 'dc.subject=';
			}
			$lookupVal3 = '"' . $lookupVal3 . '"';
		}

		#### Fourth search criteria line
		if (!empty($lookupVal4)) {
			if ($srchBy4 == "1018") {
				$srchByName4 = 'Publisher';
				$sruQry4 = 'dc.publisher=';
			}	else if ($srchBy4 == "59") {
				$srchByName4 = 'Pub Loc';
				$sruQry4 = 'bib.originPlace=/bib.portion=city ';
			}	else if ($srchBy4 == "31") {
				$srchByName4 = 'Pub Date';
				$sruQry4 = 'dc.date=';
			}	else if ($srchBy4 == "1016") {
				$srchByName4 = 'Keyword';
				$sruQry4 = 'dc.subject=';
			}
			$lookupVal4 = '"' . $lookupVal4 . '"';
		}

		#### Fifth search criteria line
		if (!empty($lookupVal5)) {
			if ($srchBy5 == "1018") {
				$srchByName5 = 'Publisher';
				$sruQry5 = 'dc.publisher=';
			}	else if ($srchBy5 == "59") {
				$srchByName5 = 'Pub Loc';
				$sruQry5 = 'bib.originPlace=/bib.portion=city ';
			}	else if ($srchBy5 == "31") {
				$srchByName5 = 'Pub Date';
				$sruQry5 = 'dc.date=';
			}	else if ($srchBy5 == "1016") {
				$srchByName5 = 'Keyword';
				$sruQry5 = 'dc.subject=';
			}
			$lookupVal5 = '"' . $lookupVal5 . '"';
		}

?>
