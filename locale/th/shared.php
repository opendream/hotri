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

setlocale(LC_MONETARY, 'th_TH.UTF-8'); // For change currency symbol
#****************************************************************************
#*  Common translation text shared among multiple pages
#****************************************************************************
$trans["sharedCancel"]             = "\$text = 'ยกเลิก';";
$trans["sharedDelete"]             = "\$text = 'ลบ';";
$trans["sharedComfirmDelete"]    = "\$text = 'ยืนยันการลบ';";
$trans["sharedDeleteWarning"]    = "\$text = 'การเปลี่ยนแปลงนี้ไม่สามารถเรียกกลับคืนได้ คุณแน่ใจหรือไม่?';";
$trans["sharedRecordIsDeleted"]    = "\$text = 'รายการถูกลบเสร็จสิ้น';";
$trans["sharedRecordsAreDeleted"]    = "\$text = 'รายการถูกลบเสร็จสิ้น';";
$trans["sharedListOfDeletedItems"]    = "\$text = 'รายการที่กำลังจะถูกลบ';";

#****************************************************************************
#*  Translation text for page biblio_view.php
#****************************************************************************
$trans["Are you sure to remove this picture?"]  = "\$text = 'ยืนยันการลบภาพนี้ใช่หรือไม่?';";
$trans["Remove"]  = "\$text = 'ลบภาพออก';";
$trans["biblioViewTble1Hdr"]       = "\$text = 'รายการบรรณานุกรม';";
$trans["biblioViewMaterialType"]   = "\$text = 'ประเภททรัพยากรสารสนเทศ';";
$trans["biblioViewCollection"]     = "\$text = 'สถานที่จัดเก็บ';";
$trans["biblioViewCallNmbr"]       = "\$text = 'เลขหมู่';";
$trans["biblioViewTble2Hdr"]       = "\$text = 'จำนวนเล่ม';";
$trans["biblioViewTble2Col1"]      = "\$text = 'รหัสบาร์โค๊ค';";
$trans["biblioViewTble2Col2"]      = "\$text = 'รายละเอียด';";
$trans["biblioViewTble2Col3"]      = "\$text = 'สถานภาพ';";
$trans["biblioViewTble2Col4"]      = "\$text = 'เปลี่ยนแปลงล่าสุดเมื่อ';";
$trans["biblioViewTble2Col5"]      = "\$text = 'กำหนดส่ง';";
$trans["biblioViewTble2ColFunc"]   = "\$text = 'เปลี่ยนแปลง';";
$trans["biblioViewTble2Coldel"]    = "\$text = 'ลบ';";
$trans["biblioViewTble2Coledit"]   = "\$text = 'แก้ไข';";
$trans["biblioViewTble3Hdr"]       = "\$text = 'รายการบรรณานุกรมอย่างละเอียด';";
$trans["biblioViewNoAddInfo"]      = "\$text = 'No additional bibliographic information available.';";
$trans["biblioViewNoCopies"]       = "\$text = 'ไมมีรายการตัวเล่ม.';";
$trans["biblioViewOpacFlg"]        = "\$text = 'แสดงใน OPAC';";
$trans["biblioViewNewCopy"]        = "\$text = 'เพิ่มรายการตัวเล่ม';";
$trans["biblioViewNeweCopy"]       = "\$text = 'Add New Electronic Copy';";
$trans["biblioViewYes"]            = "\$text = 'ใช่';";
$trans["biblioViewNo"]             = "\$text = 'ไม่';";
$trans["biblioViewPictureHeader"]  = "\$text = 'Bibliograhy Picture';";

#****************************************************************************
#*  Translation text for page biblio_search.php
#****************************************************************************
$trans["biblioSearchNoResults"]    = "\$text = 'ไม่พบผลลัพธ์จากเงื่อนไขที่ใช้ค้นหา';";
$trans["biblioSearchResults"]      = "\$text = 'ผลการสืบค้น';";
$trans["biblioSearchResultPages"]  = "\$text = 'หน้าผลสืบค้น';";
$trans["biblioSearchFirst"]        = "\$text = 'หน้าแรก';";
$trans["biblioSearchLast"]         = "\$text = 'หน้าสุดท้าย';";
$trans["biblioSearchPrev"]         = "\$text = 'ก่อนหน้านี้';";
$trans["biblioSearchNext"]         = "\$text = 'หน้าถัดไป';";
$trans["biblioSearchResultTxt"]    = "if (%items% == 1) {
                                        \$text = 'พบข้อมูล %items% รายการ';
                                      } else {
                                        \$text = 'พบข้อมูล %items% รายการ';
                                      }";
$trans["biblioSearchauthor"]       = "\$text = ' เรียงตามชื่อผู้แต่ง';";
$trans["biblioSearchtitle"]        = "\$text = ' เรียงตามชื่อเรื่อง';";
$trans["biblioSearchSortByAuthor"] = "\$text = 'เรียงตามชื่อผู้แต่ง';";
$trans["biblioSearchSortByTitle"]  = "\$text = 'เรียงตามชื่อเรื่อง';";
$trans["biblioSearchTitle"]        = "\$text = 'ชื่อเรื่อง';";
$trans["biblioSearchAuthor"]       = "\$text = 'ผู้แต่ง';";
$trans["biblioSearchMaterial"]     = "\$text = 'ชนิด';";
$trans["biblioSearchCollection"]   = "\$text = 'สถานที่จัดเก็บ';";
$trans["biblioSearchCall"]         = "\$text = 'เลขเรียกหนังสือ';";
$trans["biblioSearchCopyBCode"]    = "\$text = 'รหัสบาร์โค้ด';";
$trans["biblioSearchCopyStatus"]   = "\$text = 'สถานะ';";
$trans["biblioSearchNoCopies"]     = "\$text = 'ไม่มีสำเนาของหนังสือเล่มนี้ในระบบ';";
$trans["biblioSearchHold"]         = "\$text = 'จอง';";
$trans["biblioSearchOutIn"]        = "\$text = 'ยืม / คืน';";
$trans["biblioSearchDetail"]       = "\$text = 'ดูรายละเอียดบรรณานุกรม';";
$trans["biblioSearchBCode2Chk"]    = "\$text = 'Barcode to Check Out or Check In Form';";
$trans["biblioSearchBCode2Hold"]   = "\$text = 'Barcode to Hold Form';";

#****************************************************************************
#*  Translation text for page advanced_search.php
#****************************************************************************

$trans["advsAdvancedSearch"]       = "\$text = 'การค้นหาขั้นสูง';";
$trans["advsMaterialType"]         = "\$text = 'ประเภททรัพยากรสารสนเทศ';"; 
$trans["advsCollectionType"]       = "\$text = 'สถานที่จัดเก็บทรัพยากรสารสนเทศ';";
$trans["advsSearch"]               = "\$text = 'ค้นหา';";
$trans["advsClear"]                = "\$text = 'ล้างเงื่อนไข';";
$trans["advsPublishedYear"]          = "\$text = 'ปีที่ตีพิมพ์';";
$trans["advsLanguage"]                = "\$text = 'ภาษา';";
$trans["optThai"]                = "\$text = 'ไทย';";
$trans["optEnglish"]                = "\$text = 'อังกฤษ';";
$trans["optFrench"]                = "\$text = 'ฝรั่งเศส';";
$trans["cancel"]                   = "\$text = 'ยกเลิก';";
$trans["or"]                       = "\$text = 'หรือ';";
$trans["any"]                      = "\$text = 'ทุกประเภท';";


#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'สำหรับผู้ดูแลระบบและผู้ปฏิบัติงาน';";
$trans["loginFormUsername"]        = "\$text = 'ชื่อผู้ใช้งานระบบ';";
$trans["loginFormPassword"]        = "\$text = 'รหัสผู้ใช้งานระบบ';";
$trans["loginFormLogin"]           = "\$text = 'เข้าสู่ระบบ';";

#****************************************************************************
#*  Translation text for page hold_del_confirm.php
#****************************************************************************
$trans["holdDelConfirmMsg"]        = "\$text = 'ยืนยันในการลบรายการจองหรือไม่';";

#****************************************************************************
#*  Translation text for page hold_del.php
#****************************************************************************
$trans["holdDelSuccess"]           = "\$text='ลบรายการจองสำเร็จ';";

#****************************************************************************
#*  Translation text for page help_header.php
#****************************************************************************
$trans["helpHeaderTitle"]          = "\$text='แนะนำการใช้งาน';";
$trans["helpHeaderCloseWin"]       = "\$text='ปิดหน้าต่างนี้';";
$trans["helpHeaderContents"]       = "\$text='เนื้อหา';";
$trans["helpHeaderPrint"]          = "\$text='พิมพ์';";

$trans["catalogResults"]           = "\$text='ผลการสืบค้น';";

#****************************************************************************
#*  Translation text for page header.php and header_opac.php
#****************************************************************************
$trans["headerTodaysDate"]         = "\$text='เวลาปัจจุบัน:';";

// execute thai date statements
$trans["headerDateFormat"]         = <<<INNERHTML

\$this_date = explode('-', date('D-j-m-Y'));
\$thDay = array(
  'Sun' => 'อาทิตย์',
  'Mon' => 'จันทร์',
  'Tue' => 'อังคาร',
  'Wed' => 'พุธ',
  'Thu' => 'พฤหัส',
  'Fri' => 'ศุกร์',
  'Sat' => 'เสาร์',
);
\$thMonth = array(
  1 => 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
  'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
\$thMonthLong = array(
  1 => 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน',
  'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
  'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
  

  
\$text='วัน' . \$thDay[\$this_date[0]] . 'ที่ ' . \$this_date[1] . ' ' . \$thMonthLong[0+\$this_date[2]] . ' พ.ศ.' . (543 + \$this_date[3]);

INNERHTML;
$trans["headerLibraryHours"]       = "\$text='เวลาเปิดบริการ:';";
$trans["headerLibraryPhone"]       = "\$text='ติดต่อ:';";
$trans["headerHome"]               = "\$text='หน้าหลัก';";
$trans["headerCirculation"]        = "\$text='สมาชิกห้องสมุด';";
$trans["headerCataloging"]         = "\$text='งานลงรายการทรัพยากรสารสนเทศ';";
$trans["headerAdmin"]              = "\$text='งานดูแลระบบ';";
$trans["headerReports"]            = "\$text='รายงาน';";

#****************************************************************************
#*  Translation text for page footer.php
#****************************************************************************
$trans["footerLibraryHome"]        = "\$text='  หน้าหลักห้องสมุด';";
$trans["footerOPAC"]               = "\$text='สืบค้น';";
$trans["footerHelp"]               = "\$text='แนะนำการใช้งาน';";
$trans["footerPoweredBy"]          = "\$text='พัฒนาเพิ่มเติมโดย นายประสิทธิชัย เลิศรัตนเคหกาล จาก OpenBiblio รุ่น';";
$trans["footerDatabaseVersion"]    = "\$text='เลขรุ่นฐานข้อมูล';";
$trans["footerCopyright"]          = "\$text='สงวนลิขสิทธิ์';";
$trans["footerUnderThe"]           = "\$text='ซอร์สโค้ดอยู่ภายใต้ลิขสิทธิ์';";
$trans["footerGPL"]                = "\$text='GNU General Public License';";

?>
