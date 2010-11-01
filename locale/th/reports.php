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
$trans["reportsCancel"]            = "\$text = 'ยกเลิก';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = '	รายงาน';";
$trans["indexDesc"]                = "\$text = 'Use the report or label list located in the left hand navigation area to produce reports or labels.';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'แสดงผลรายงานและสถิติ';";
$trans["reportListDesc"]           = "\$text = 'เลือกการออกรายงานจากด้านล่างนี้';";
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
$trans["HTML (page-by-page)"] = "\$text = 'HTML (แบ่งเป็นหน้าๆ)';";
$trans["HTML (one big page)"]  = "\$text = 'HTML (แสดงทั้งหมด)';";
$trans["CSV"]                                = "\$text = 'CSV';";
$trans["Microsoft Excel"]            = "\$text = 'Microsoft Excel';";

#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'report selection criteria';";
$trans["runReportReturnLink2"]     = "\$text = 'รายการรายงาน';";
$trans["runReportTotal"]           = "\$text = 'Total Rows:';";
$trans["Print list"]                        = "\$text = 'พิมพ์รายการ';";
$trans["Labels"]                           = "\$text = 'ฉลากติดหนังสือ';";
$trans["reportsResultNotFound"]  = "\$text = 'ไม่พบผลลัพธ์ใดๆ';";
$trans["reportsResultFound"]        = "\$text = 'พบผลลัพธ์ %results% รายการ';";
$trans["Report Results:"]                = "\$text = 'รายการผลลัพธ์:';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'Field must be numeric.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Error occurred parsing report definition xml.  Error = ';";
$trans["displayLabelsCannotRead"]  = "\$text = 'Cannot read label file: %fileName%';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'คุณไม่มีสิทธิ์สำหรับการใช้งานในส่วนนี้';";

#****************************************************************************
#*  Report Titles
#****************************************************************************
$trans["Copy Search"]                                       = "\$text = 'สืบค้นสำเนา';";
$trans["Item Checkout History"]                     = "\$text = 'ประวัติย้อนหลังการยืมทรัพยากรสารสนเทศ';";
$trans["reportHolds"]              = "\$text = 'รายการจองทรัพยากรสารสนเทศพร้อมข้อมูลสมาชิก';";
$trans["reportCheckouts"]          = "\$text = 'รายงานการยืมทรัพยากรสารสนเทศ';";
$trans["Over Due Letters"]           = "\$text = 'จดหมายแจ้งเตือนยืมเกินกำหนด';";
$trans["reportLabels"]             = "\$text = 'พิมพ์ฉลากพร้อมบาร์โค้ด';";
$trans["popularBiblios"]           = "\$text = 'รายงานทรัพยากรสารสนเทศที่ถูกยืมมากที่สุด';";
$trans["overdueList"]              = "\$text = 'รายงานการยืมทรัพยากรสารสนเทศเกินกำหนด';";
$trans["balanceDueList"]           = "\$text = 'ตรวจสอบยอดค่าปรับสมาชิก';";
$trans["Cataloging"]                  = "\$text = 'งานลงรายการทรัพยากรสารสนเทศ';";
$trans["Circulation"]                  = "\$text = 'สมาชิกห้องสมุด';";
$trans["Bulk summary"]            = "\$text = 'รายงานจากระบบสืบค้นฐานข้อมูลห้องสมุด';";

#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Multi Label Example';";
$trans["labelsSimple"]             = "\$text = 'Simple Label Example';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'Biblio ID';";
$trans["biblio.create_dt"]         = "\$text = 'วันที่เพิ่มเข้าระบบ';";
$trans["biblio.last_change_dt"]    = "\$text = 'ปรับปรุงครั้งสุดท้ายเมื่อ';";
$trans["biblio.material_cd"]       = "\$text = 'ประเภททรัพยากร';";
$trans["biblio.collection_cd"]     = "\$text = 'สถานที่จัดเก็บ';";
$trans["biblio.call_nmbr1"]        = "\$text = 'เลขเรียก 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'เลขเรียก 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'เลขเรียก 3';";
$trans["biblio.title_remainder"]   = "\$text = 'ชื่อเรื่องรอง';";
$trans["biblio.responsibility_stmt"] = "\$text = 'ส่วนแจ้งผู้รับผิดชอบ';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC Flag';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'รหัสบาร์โค้ด';";
$trans["biblio.title"]             = "\$text = 'ชื่อเรื่อง';";
$trans["biblio.author"]            = "\$text = 'ผู้แต่ง';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'วันที่เริ่มต้นสถานะนี้';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'วันที่กำหนดคืน';";
$trans["member.mbrid"]             = "\$text = 'Member ID';";
$trans["member.barcode_nmbr"]      = "\$text = 'รหัสบาร์โค้ดสมาชิก';";
$trans["member.last_name"]         = "\$text = 'นามสกุล';";
$trans["member.first_name"]        = "\$text = 'ชื่อ';";
$trans["member.address"]          = "\$text = 'ที่อยู่';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'วันที่เริ่มจอง';";
$trans["member.home_phone"]        = "\$text = 'หมายเลขโทรศัพท์บ้าน';";
$trans["member.work_phone"]        = "\$text = 'หมายเลขโทรศัพท์ที่ทำงาน';";
$trans["member.email"]             = "\$text = 'อีเมล์';";
$trans["biblio_status_dm.description"] = "\$text = 'สถานะ';";
$trans["settings.library_name"]    = "\$text = 'ชื่อห้องสมุด';";
$trans["settings.library_hours"]   = "\$text = 'เวลาเปิดปิด';";
$trans["settings.library_phone"]   = "\$text = 'หมายเลขโทรศัพท์';";
$trans["days_late"]                = "\$text = 'เกินเวลามากี่วัน';";
$trans["due_back_dt"]              = "\$text = 'วันที่คืน';";
$trans["checkoutCount"]            = "\$text = 'จำนวนครั้งที่ถูกยืม';";

$trans["reportDateMonth01"]   = "\$text = 'มกราคม';";
$trans["reportDateMonth02"]   = "\$text = 'กุมภาพันธ์';";
$trans["reportDateMonth03"]   = "\$text = 'มีนาคม';";
$trans["reportDateMonth04"]   = "\$text = 'เมษายน';";
$trans["reportDateMonth05"]   = "\$text = 'พฤษภาคม';";
$trans["reportDateMonth06"]   = "\$text = 'มิถุนายน';";
$trans["reportDateMonth07"]   = "\$text = 'กรกฎาคม';";
$trans["reportDateMonth08"]   = "\$text = 'สิงหาคม';";
$trans["reportDateMonth09"]   = "\$text = 'กันยายน';";
$trans["reportDateMonth10"]   = "\$text = 'ตุลาคม';";
$trans["reportDateMonth11"]   = "\$text = 'พฤศจิกายน';";
$trans["reportDateMonth12"]   = "\$text = 'ธันวาคม';";

$trans["Barcode"] = "\$text = 'หมายเลขบาร์โค้ด';";
$trans["Title"]       = "\$text = 'ชื่อเรื่อง';";
$trans["Barcode Starts With"] = "\$text = 'หมายเลขบาร์โค้ดที่ขึ้นต้นด้วย';";
$trans["Newer than"]               = "\$text = 'แสดงรายการใหม่ตั้งแต่วันที่';";
$trans["Sort By"]                       = "\$text = 'เรียงตาม';";
$trans["Format"]                       = "\$text = 'รูปแบบการแสดงผล';";
$trans["Minimum balance"]     = "\$text = 'ยอดขั้นต่ำ';";
$trans["Call Number"]              = "\$text = 'เลขเรียกหนังสือ';";
$trans["Placed before"]           = "\$text = 'จนถึงก่อนวันที่';";
$trans["Placed since"]              = "\$text = 'ตั้งแต่วันที่';";
$trans["As of"]                           = "\$text = 'อ้างอิงจากวันที่';";
$trans["Due before"]                = "\$text = 'ถึงกำหนดคืนก่อนวันที่';";
$trans["Out since"]                   = "\$text = 'ยืมไปตั้งแต่วันที่';";
$trans["reportsReverse"]        = "\$text = '(มากไปน้อย)';";
$trans["Member Name"]          = "\$text = 'ชื่อสมาชิก';";
$trans["Balance Due"]              = "\$text = 'ยอดค่าปรับ';";
$trans["bulkReportBibID"]        = "\$text = 'Biblio ID';";
$trans["bulkReportBibName"]  = "\$text = 'ชื่อเรื่อง';";
$trans["bulkReportNoItem"]     = "\$text = 'ไม่มีทรัพยากรใดที่เข้าข่ายนี้';";
$trans["bulkReportAllCovered"]       = "\$text = 'ทรัพยากรทั้งหมดมีภาพปกครบถ้วนแล้ว';";
$trans["bulkReportConfirmPurge"]  = "\$text = 'ยืนยันการล้างข้อมูลในรายการนี้หรือไม่?';";
$trans["bulkReportPurgeDone"]       = "\$text = 'ล้างข้อมูลออกจากรายการนี้เรียบร้อยแล้ว';";
$trans["bulkReportConfirmRemoveISBN"] = "\$text = 'ยืนยันการลบข้อมูล ISBN เลขที่ %isbn% หรือไม่?';";
$trans["bulkReportISBNRemoved"]  = "\$text = 'ลบ ISBN เลขที่ %isbn% ออกจากรายการแล้ว';";
$trans["bulkReportZeroHits"]           = "\$text = 'มีรายการที่นำเข้าสำเร็จค้างอยู่ในรายการอยู่ %zero_hits% รายการ <a href=\"bulk_report.php?type=manual&act=cleartemp\">ล้างออกทั้งหมด</a>';";
$trans["bulkReportZeroHitsClear"]  = "\$text = 'ลบรายการที่นำเข้าสำเร็จออกจากรายการนี้แล้ว';";
$trans["function"]                       = "\$text = 'คำสั่ง';";
$trans["add"]                               = "\$text = 'กรอกข้อมูล';";
$trans["edit"]                               = "\$text = 'แก้ไข';";
$trans["remove"]                        = "\$text = 'ลบจากรายการ';";
$trans["Hits"]                               = "\$text = 'จำนวนสำเนา';";
$trans["Created"]                        = "\$text = 'วันที่เพิ่มเข้าระบบ';";
$trans["Export to file"]               = "\$text = 'บันทึกเป็นเอกสารรายการ';";
$trans["Purge all items"]            = "\$text = 'ล้างข้อมูลทั้งหมด';";
$trans["Submit"]                          = "\$text = 'สร้างรายงาน';";

$trans["Call Num."]                     = "\$text = 'เลขเรียกหนังสือ';";
$trans["Author"]                          = "\$text = 'ผู้แต่ง';";
$trans["collection"]                     = "\$text = 'สถานที่จัดเก็บ';";
$trans["Checkout Date"]           = "\$text = 'วันที่ยืม';";
$trans["Due Date"]                     = "\$text = 'กำหนดคืน';";
$trans["Hold Date"]                    = "\$text = 'วันที่จอง';";
$trans["Member Barcode"]       = "\$text = 'หมายเลขสมาชิก';";
?>
