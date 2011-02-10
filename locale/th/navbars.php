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
#*  Translation text shared by various php files under the navbars dir
#****************************************************************************
$trans["login"]                    = "\$text = 'ลงชื่อเข้าใช้';";
$trans["logout"]                   = "\$text = 'ออกจากระบบ';";
$trans["help"]                     = "\$text = 'แนะนำการใช้งาน';";

#****************************************************************************
#*  Translation text for page home.php
#****************************************************************************
$trans["homeHomeLink"]             = "\$text = 'หน้าหลัก';";
$trans["homeLicenseLink"]          = "\$text = 'เงื่อนไขการใช้งาน';";
$trans["homeCreditsLink"]           = "\$text = 'รายชื่อผู้พัฒนา';";

#****************************************************************************
#*  Translation text for page admin.php
#****************************************************************************
$trans["adminSummary"]             = "\$text = 'ส่วนดูแลระบบ';";
$trans["adminStaff"]               = "\$text = 'ผู้ใช้งานระบบ';";
$trans["adminSettings"]            = "\$text = 'ตั้งค่าห้องสมุด';";
$trans["adminMaterialTypes"]       = "\$text = 'ประเภททรัพยากรสารสนเทศ';";
$trans["adminCollections"]         = "\$text = 'สถานที่จัดเก็บทรัพยากรสารสนเทศ';";
$trans["adminCheckoutPriv"]     = "\$text = 'สิทธิการยืมทรัพยากรสารสนเทศ';";
$trans["Cover Lookup Options"]  = "\$text = 'ตั้งค่าระบบสืบค้นปกหนังสือ';";
$trans["adminThemes"]              = "\$text = 'หน้าจอระบบ';";
$trans["adminTranslation"]         = "\$text = 'การแปล';";
$trans["Member Types"]            = "\$text = 'กลุ่มสมาชิก';";
$trans["Member Fields"]             = "\$text = 'ฟิลด์สมาชิก';";
$trans["adminImportExport"]        = "\$text = 'นำเข้า / ส่งออก';";

#****************************************************************************
#*  Translation text for page cataloging.php
#****************************************************************************
$trans["catalogSummary"]           = "\$text = 'สรุปรายการบรรณานุกรม';";
$trans["catalogSearch1"]           = "\$text = 'ค้นหารายการบรรณานุกรม';";
$trans["catalogSearch2"]           = "\$text = 'ค้นหารายการบรรณานุกรม';";
$trans["catalogResults"]           = "\$text = 'ผลการสืบค้น';";
$trans["catalogBibInfo"]           = "\$text = 'จัดการรายการบรรณานุกรม';";
$trans["catalogBibEdit"]           = "\$text = 'แก้ไขข้อมูลรายการบรรณานุกรม';";
$trans["catalogBibEditMarc"]       = "\$text = 'แก้ไขระเบียน MARC';";
$trans["catalogBibMarcNewFld"]     = "\$text = 'เพิ่มระเบียน MARC ';";
$trans["catalogBibMarcNewFldShrt"] = "\$text = 'เพิ่มระเบียน MARC';";
$trans["catalogBibMarcEditFld"]    = "\$text = 'แก้ไข MARC ';";
$trans["catalogCopyNew"]           = "\$text = 'เพิ่มรายการตัวเล่ม';";
$trans["catalogCopyEdit"]          = "\$text = 'แก้ไขรายการตัวเล่ม';";
$trans["catalogHolds"]             = "\$text = 'รายการจอง';";
$trans["catalogDelete"]            = "\$text = 'ลบรายการ';";
$trans["catalogBibNewLike"]        = "\$text = 'คัดลอกรายการบรรณานุกรม';";
$trans["catalogBibNew"]            = "\$text = 'เพิ่มรายการบรรณานุกรม';";
$trans["catalogBibBulkDelete"]  = "\$text = 'ลบหลายบรรณานุกรม';";
$trans["CSVImport"]                  = "\$text = 'นำเข้าจากไฟล์ CSV';";
$trans["Upload Marc Data"]         = "\$text = 'นำเข้ารายการ MARC';";

#****************************************************************************
#*  Translation text for page reports.php
#****************************************************************************
$trans["reportsSummary"]           = "\$text = 'สรุปรายงาน';";
$trans["reportsReportListLink"]    = "\$text = 'รายงาน';";
$trans["reportsLabelsLink"]        = "\$text = 'พิมพ์รายการเลขเรียกหนังสือ';";
$trans["reportsLettersLink"]        = "\$text = 'พิมพ์จดหมายแจ้งเตือน';";
$trans["reportsResult"]               = "\$text = 'แสดงรายงาน';";
$trans["reportsCriteria"]               = "\$text = 'ตัวกรองรายงาน';";
$trans["reportsFailedImport"]     = "\$text = 'ทรัพยากรสารสนเทศที่นำเข้าไม่สำเร็จ';";
$trans["reportsNoCover"]            = "\$text = 'ทรัพยากรสารสนเทศที่ไม่มีภาพปก';";

#****************************************************************************
#*  Translation text for page opac.php
#****************************************************************************
$trans["catalogSearch1"]           = "\$text = 'ค้นหา';";
$trans["catalogSearch2"]           = "\$text = 'ค้นหาใหม่';";
$trans["catalogResults"]           = "\$text = 'ผลการสืบค้น';";
$trans["catalogBibInfo"]           = "\$text = 'จัดการบรรณานุกรม';";

#Added

$trans["memberInfo"]="\$text = 'ข้อมูลสมาชิก';";
$trans["memberSearch"]="\$text = 'ค้นหาสมาชิก';";
$trans["editInfo"]="\$text = 'แก้ไขข้อมูลสมาชิก';";
$trans["checkoutHistory"]= "\$text = 'ประวัติการยืม';";
$trans["account"]="\$text = 'รายการค่าปรับ';";
$trans["checkIn"]="\$text = 'คืนทรัพยากรสารสนเทศ';";
$trans["memberSearch"]= "\$text = 'ค้นหาสมาชิก';";
$trans["newMember"]= "\$text = 'เพิ่มสมาชิกใหม่';";
//$trans["account"]        	= "\$text = 'Account';";
#****************************************************************************
#* Translation text for Amazon mod
#****************************************************************************
$trans["amazon_Search"]             = "\$text = 'ถ่ายโอนข้อมูลจาก Amazon';";
   #****************************************************************************
  #* Translation text for Library of Congress SRU module
  #****************************************************************************
  $trans["LOCsearch"]                 = "\$text = 'ถ่ายโอนข้อมูลจาก Library of Congress';";

#****************************************************************************
#*  Translation text for page lookup.php for lookup2
#****************************************************************************
$trans["lookup"]                = "\$text = 'ค้นหาแบบออนไลน์';";
$trans["lookup_opts"]       		= "\$text = 'ตั้งค่าระบบสืบค้นฐานข้อมูลห้องสมุด';";
$trans["lookup_hosts"]       		= "\$text = 'เครื่องแม่ข่ายฐานข้อมูลห้องสมุด';";
$trans["lookup_bulk"]       		= "\$text = 'สืบค้นฐานข้อมูลจากรายการ ISBN';";
