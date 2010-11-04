<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/**********************************************************************************
 *   Instructions for translators:
 *
 *   All gettext key/value pairs are specified as follows:
 *     $trans["key"] = "<php translation code to set the $text variable>";
 *   Allowing translators the ability to execute php code withint the transFunc string
 *   provides the maximum amount of flexibility to format the languange syntax.
 *
 *   Formatting rules:
 *   - Resulting translation string must be stored in a variable called $text.
 *   - Input arguments must be surrounded by % characters (i.e. %pageCount%).
 *   - A backslash ('\') needs to be placed before any special php characters 
 *     (such as $, ", etc.) within the php translation code.
 *
 *   Simple Example:
 *     $trans["homeWelcome"]       = "\$text='Welcome to OpenBiblio';";
 *
 *   Example Containing Argument Substitution:
 *     $trans["searchResult"]      = "\$text='page %page% of %pages%';";
 *
 *   Example Containing a PHP If Statment and Argument Substitution:
 *     $trans["searchResult"]      = 
 *       "if (%items% == 1) {
 *         \$text = '%items% result';
 *       } else {
 *         \$text = '%items% results';
 *       }";
 *
 **********************************************************************************
 */

#****************************************************************************
#*  Translation text used on multiple pages
#****************************************************************************
$trans["reportsCancel"]            = "\$text = 'Cancel';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Reports';";
$trans["indexDesc"]                = "\$text = 'Use the report or label list located in the left hand navigation area to produce reports or labels.';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'Report List';";
$trans["reportListDesc"]           = "\$text = 'Choose from one of the following links to run a report.';";
$trans["reportListXmlErr"]         = "\$text = 'Error occurred parsing report definition xml.';";
$trans["reportListCannotRead"]     = "\$text = 'Cannot read label file: %fileName%';";

#****************************************************************************
#*  Translation text for page label_list.php
#****************************************************************************
$trans["labelListHdr"]             = "\$text = 'Label List';";
$trans["labelListDesc"]            = "\$text = 'Choose from one of the following links to produce labels in pdf format.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";

#****************************************************************************
#*  Translation text for page letter_list.php
#****************************************************************************
$trans["letterListHdr"]            = "\$text = 'Letter List';";
$trans["letterListDesc"]           = "\$text = 'Choose from one of the following links to produce letters in pdf format.';";
$trans["displayLettersXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";

#****************************************************************************
#*  Translation text for page report_criteria.php
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Report Search Criteria (optional)';";
$trans["reportCriteriaHead2"]      = "\$text = 'Report Sort Order (optional)';";
$trans["reportCriteriaHead3"]      = "\$text = 'Report Output Type';";
$trans["reportCriteriaCrit1"]      = "\$text = 'Criteria 1:';";
$trans["reportCriteriaCrit2"]      = "\$text = 'Criteria 2:';";
$trans["reportCriteriaCrit3"]      = "\$text = 'Criteria 3:';";
$trans["reportCriteriaCrit4"]      = "\$text = 'Criteria 4:';";
$trans["reportCriteriaEQ"]         = "\$text = '=';";
$trans["reportCriteriaNE"]         = "\$text = 'not =';";
$trans["reportCriteriaLT"]         = "\$text = '&lt;';";
$trans["reportCriteriaGT"]         = "\$text = '&gt;';";
$trans["reportCriteriaLE"]         = "\$text = '&lt or =';";
$trans["reportCriteriaGE"]         = "\$text = '&gt or =';";
$trans["reportCriteriaBT"]         = "\$text = 'between';";
$trans["reportCriteriaAnd"]        = "\$text = 'and';";
$trans["reportCriteriaRunReport"]  = "\$text = 'Run Report';";
$trans["reportCriteriaSortCrit1"]  = "\$text = 'Sort 1:';";
$trans["reportCriteriaSortCrit2"]  = "\$text = 'Sort 2:';";
$trans["reportCriteriaSortCrit3"]  = "\$text = 'Sort 3:';";
$trans["reportCriteriaAscending"]  = "\$text = 'ascending';";
$trans["reportCriteriaDescending"] = "\$text = 'descending';";
$trans["reportCriteriaStartOnLabel"] = "\$text = 'Start printing on label:';";
$trans["reportCriteriaOutput"]     = "\$text = 'Output Type:';";
$trans["reportCriteriaOutputHTML"] = "\$text = 'HTML';";
$trans["reportCriteriaOutputCSV"]  = "\$text = 'CSV';";
$trans["HTML (page-by-page)"] = "\$text = 'HTML (page-by-page)';";
$trans["HTML (one big page)"]  = "\$text = 'HTML (one big page)';";
$trans["CSV"]                                = "\$text = 'CSV';";
$trans["Microsoft Excel"]            = "\$text = 'Microsoft Excel';";

#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'report selection criteria';";
$trans["runReportReturnLink2"]     = "\$text = 'report list';";
$trans["runReportTotal"]           = "\$text = 'Total Rows:';";
$trans["Print list"]                        = "\$text = 'Print list';";
$trans["Labels"]                           = "\$text = 'Labels';";
$trans["reportsResultNotFound"]  = "\$text = 'No results found.';";
$trans["reportsResultFound"]        = "\$text = '%results% results found.';";
$trans["Report Results:"]                = "\$text = 'Report Results:';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'Field must be numeric.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";
$trans["displayLabelsCannotRead"]  = "\$text = 'Cannot read label file: %fileName%';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'You are not authorized to use the Reports tab.';";

#****************************************************************************
#*  Report Titles
#****************************************************************************
$trans["Copy Search"]                                       = "\$text = 'Copy Search';";
$trans["Item Checkout History"]                     = "\$text = 'Item Checkout History';";
$trans["reportHolds"]              = "\$text = 'Hold Requests Containing Member Contact Info';";
$trans["reportCheckouts"]          = "\$text = 'Bibliography Checkout Listing';";
$trans["Over Due Letters"]           = "\$text = 'Over Due Letters';";
$trans["reportLabels"]             = "\$text = 'Label Printing Query (used by labels)';";
$trans["popularBiblios"]           = "\$text = 'Most Popular Bibliographies';";
$trans["overdueList"]              = "\$text = 'Over Due Member List';";
$trans["balanceDueList"]           = "\$text = 'Balance Due Member List';";
$trans["Cataloging"]                  = "\$text = 'Cataloging';";
$trans["Circulation"]                  = "\$text = 'Circulation';";
$trans["Bulk summary"]            = "\$text = 'Bulk summary';";

#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Multi Label Example';";
$trans["labelsSimple"]             = "\$text = 'Simple Label Example';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'Biblio ID';";
$trans["biblio.create_dt"]         = "\$text = 'Date Added';";
$trans["biblio.last_change_dt"]    = "\$text = 'Last Changed';";
$trans["biblio.material_cd"]       = "\$text = 'Material Cd';";
$trans["biblio.collection_cd"]     = "\$text = 'Collection';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Call 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'Call 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'Call 3';";
$trans["biblio.title_remainder"]   = "\$text = 'Title Remainder';";
$trans["biblio.responsibility_stmt"] = "\$text = 'Stmt of Resp';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC Flag';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'Barcode';";
$trans["biblio.title"]             = "\$text = 'Title';";
$trans["biblio.author"]            = "\$text = 'Author';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'Status Begin Date';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'Due Back Date';";
$trans["member.mbrid"]             = "\$text = 'Member ID';";
$trans["member.barcode_nmbr"]      = "\$text = 'Member Barcode';";
$trans["member.last_name"]         = "\$text = 'Last Name';";
$trans["member.first_name"]        = "\$text = 'First Name';";
$trans["member.address"]          = "\$text = 'Address';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'Hold Begin Date';";
$trans["member.home_phone"]        = "\$text = 'Home Phone';";
$trans["member.work_phone"]        = "\$text = 'Work Phone';";
$trans["member.email"]             = "\$text = 'Email';";
$trans["biblio_status_dm.description"] = "\$text = 'Status';";
$trans["settings.library_name"]    = "\$text = 'Library Name';";
$trans["settings.library_hours"]   = "\$text = 'Library Hours';";
$trans["settings.library_phone"]   = "\$text = 'Library Phone';";
$trans["days_late"]                = "\$text = 'Days Late';";
$trans["due_back_dt"]              = "\$text = 'Due Back';";
$trans["checkoutCount"]            = "\$text = 'Checkout Count';";

$trans["reportDateMonth01"]   = "\$text = 'January';";
$trans["reportDateMonth02"]   = "\$text = 'February';";
$trans["reportDateMonth03"]   = "\$text = 'March';";
$trans["reportDateMonth04"]   = "\$text = 'April';";
$trans["reportDateMonth05"]   = "\$text = 'May';";
$trans["reportDateMonth06"]   = "\$text = 'June';";
$trans["reportDateMonth07"]   = "\$text = 'July';";
$trans["reportDateMonth08"]   = "\$text = 'August';";
$trans["reportDateMonth09"]   = "\$text = 'September';";
$trans["reportDateMonth10"]   = "\$text = 'October';";
$trans["reportDateMonth11"]   = "\$text = 'November';";
$trans["reportDateMonth12"]   = "\$text = 'December';";

$trans["Barcode"] = "\$text = 'Barcode';";
$trans["Title"]       = "\$text = 'Title';";
$trans["Barcode Starts With"] = "\$text = 'Barcode Starts With';";
$trans["Newer than"]               = "\$text = 'Newer than';";
$trans["Sort By"]                       = "\$text = 'Sort By';";
$trans["Format"]                       = "\$text = 'Format';";
$trans["Minimum balance"]     = "\$text = 'Minimum balance';";
$trans["Call Number"]              = "\$text = 'Call Number';";
$trans["Placed before"]           = "\$text = 'Placed before';";
$trans["Placed since"]              = "\$text = 'Placed since';";
$trans["As of"]                           = "\$text = 'As of';";
$trans["Due before"]               = "\$text = 'Due before';";
$trans["Out since"]                   = "\$text = 'Out since';";
$trans["reportsReverse"]        = "\$text = '(Reverse)';";
$trans["Member Name"]          = "\$text = 'Member name';";
$trans["Balance Due"]              = "\$text = 'Balance';";
$trans["bulkReportBibID"]        = "\$text = 'Biblio ID';";
$trans["bulkReportBibName"]  = "\$text = 'Biblio Name';";
$trans["bulkReportNoItem"]     = "\$text = 'No failed items yet.';";
$trans["bulkReportAllCovered"]       = "\$text = 'All items have their book cover.';";
$trans["bulkReportConfirmPurge"]  = "\$text = 'Are you sure to purge ISBN list?';";
$trans["bulkReportPurgeDone"]       = "\$text = 'All items has been purged from failed list.';";
$trans["bulkReportConfirmRemoveISBN"] = "\$text = 'Are you sure to remove ISBN: %isbn%?';";
$trans["bulkReportISBNRemoved"]  = "\$text = 'ISBN %isbn% has been removed from failed list.';";
$trans["bulkReportZeroHits"]           = "\$text = 'Found %zero_hits% hidden items (nothing copy), <a href=\"bulk_report.php?type=manual&act=cleartemp\">clear now.</a>';";
$trans["bulkReportZeroHitsClear"]  = "\$text = 'Hidden items (no copy) has been removed from failed list.';";
$trans["function"]                       = "\$text = 'Function';";
$trans["add"]                               = "\$text = 'add';";
$trans["edit"]                               = "\$text = 'edit';";
$trans["remove"]                        = "\$text = 'remove';";
$trans["Hits"]                               = "\$text = 'Hits';";
$trans["Created"]                        = "\$text = 'Created Date';";
$trans["Export to file"]               = "\$text = 'Export to file';";
$trans["Purge all items"]            = "\$text = 'Purge all items';";
$trans["Submit"]                          = "\$text = 'Submit';";

$trans["Call Num."]                     = "\$text = 'Call Num.';";
$trans["Author"]                          = "\$text = 'Author';";
$trans["collection"]                     = "\$text = 'Collection';";
$trans["Checkout Date"]           = "\$text = 'Checkout Date';";
$trans["Due Date"]                     = "\$text = 'Due Date';";
$trans["Hold Date"]                    = "\$text = 'Hold Date';";
$trans["Member Barcode"]       = "\$text = 'Member Barcode';";

$trans['rptFormattedDate']      = "\$text = date('j M Y', strtotime('%date%'));";
$trans['rptFormattedShortDate'] = "\$text = date('j F Y', strtotime('%date%'));";
$trans['rptLetterDear']              = "\$text = 'Dear %lastName% %firstName%:';";
$trans['rptLetterDetails']          = "\$text = 'Our records show that the following library items are checked out under your name and are past due.  Please return them as soon as possible and pay any late fees due.';";
$trans['rptLetterFooter']           = "\$text = 'Sincerely,<br />The library staff at ' . OBIB_LIBRARY_NAME;";
?>
