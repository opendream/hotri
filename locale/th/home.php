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
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHeading"]       = "\$text='ระบบสืบค้นรายการทรัพยากรสารสนเทศออนไลน์';";
$trans["indexIntro"]         = "\$text=
  'ใช้เมนู(ด้านบน)สำหรับการจัดการโมดูลงานต่างๆ ของห้องสมุด (สามารถศึกษาตามคำแนะนำด้านล่างนี้)';";
$trans["indexTab"] = "\$text='หัวข้อ';";
$trans["indexDesc"] = "\$text='คำอธิบาย';";
$trans["indexCirc"] = "\$text='ระบบสมาชิกห้องสมุด';";
$trans["indexCircDesc1"] = "\$text='ใช้เมนูนี้สำหรับจัดการระบบสมาชิก)';";
$trans["indexCircDesc2"] = "\$text='ระบบสมาชิก (เพิ่ม, ค้นหา, แก้ไข, ลบ)';";
$trans["indexCircDesc3"] = "\$text='ระบบยืมทรัพยากรสารสนเทศ';";
$trans["indexCircDesc4"] = "\$text='ระบบคืนทรัพยากรสาสนเทศ';";
//$trans["indexCircDesc5"] = "\$text='Member late fee payment';";
$trans["indexCat"] = "\$text='งานลงรายการทรัพยากรสารสนเทศ';";
$trans["indexCatDesc1"] = "\$text='ใช้เมนูนสำหรับบันทึกข้อมูลรายการบรรณานุกรม';";
$trans["indexCatDesc2"] = "\$text='เพิ่ม, ค้นหา, แก้ไข, ลบ, นำเข้า, ส่งออก';";
$trans["indexCatDesc3"] = "\$text='ถ่ายโอนข้อมูลบรรณานุกรมจาก Amazon.com และ Library of congress';";
$trans["indexAdmin"] = "\$text='งานดูแลระบบ';";
$trans["indexAdminDesc1"] = "\$text='ใช้เมนูสำหรับกำหนดผู้ใช้ปฏิบัติงานและผู้ดูแลระบบ ';";
$trans["indexAdminDesc2"] = "\$text='ผู้ใช้งานระบบ (เพิ่ม, แก้ไข, รหัสผ่าน, ลบ)';";
$trans["indexAdminDesc3"] = "\$text='ตั้งค่าทั่วไปเกี่ยวกับห้องสมุด';";
$trans["indexAdminDesc5"] = "\$text='แสดงหมวดหมู่';";
$trans["indexAdminDesc4"] = "\$text='ประเภททรัพยากรสารสนเทศ';";
$trans["indexAdminDesc6"] = "\$text='จัดการหน้าจอระบบ';";
$trans["indexReports"] = "\$text='รายงาน';";
$trans["indexReportsDesc1"] = "\$text='ใช้เมนูนี้สำหรับออกผลรายงานและสถิติ';";
$trans["indexReportsDesc2"] = "\$text='แสดงผลรายงานและสถิติต่างๆ';";
$trans["indexReportsDesc3"] = "\$text='บาร์โค้ด';"; 


?>
