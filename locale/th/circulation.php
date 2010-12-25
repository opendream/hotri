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
#*  Common translation text shared among multiple pages
#****************************************************************************
$trans["circCancel"]              = "\$text = 'ยกเลิก';";
$trans["circDelete"]              = "\$text = 'ลบ';";
$trans["circSuspend"]             = "\$text = 'ระงับชั่วคราว';";
$trans["circPermanentlyDelete"]   = "\$text = 'ลบถาวร';";
$trans["circLogout"]              = "\$text = 'ออกจากระบบ';";
$trans["circAdd"]                 = "\$text = 'เพิ่ม';";
$trans["mbrDupBarcode"]           = "\$text = 'รหัสบาร์โค้ด, %barcode%, ปัจจุบันถูกใช้';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHeading"]            = "\$text='สมาชิกห้องสมุด';";
$trans["indexCardHdr"]            = "\$text='ค้นหาจากเลขที่สมาชิก:';";
$trans["indexCard"]               = "\$text='เลขที่สมาชิก:';";
$trans["indexSearch"]             = "\$text='ค้นหา';";
$trans["indexNameHdr"]            = "\$text='ค้นหาจากชื่อสมาชิก:';";
$trans["indexName"]               = "\$text='ชื่อสมาชิก:';";

#****************************************************************************
#*  Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php
#****************************************************************************
$trans["Mailing Address:"]        = "\$text='ที่อยู่:';";
$trans["mbrNewForm"]              = "\$text='เพิ่มสมาชิกใหม่';";
$trans["mbrEditForm"]             = "\$text='แก้ไข';";
$trans["mbrFldsHeader"]           = "\$text=':';";
$trans["mbrFldsCardNmbr"]         = "\$text='เลขที่สมาชิก:';";
$trans["mbrFldsLastName"]         = "\$text='ชื่อ:';";
$trans["mbrFldsFirstName"]        = "\$text='นามสกุล:';";
$trans["mbrFldsAddr1"]            = "\$text='ที่อยู่ 1:';";
$trans["mbrFldsAddr2"]            = "\$text='ที่อยู่ 2:';";
$trans["mbrFldsCity"]             = "\$text='จังหวัด:';";
$trans["mbrFldsStateZip"]         = "\$text='รหัสไปรษณีย์:';";
$trans["mbrFldsHomePhone"]        = "\$text='เบอร์โทรศัพท์ที่บ้าน:';";
$trans["mbrFldsWorkPhone"]        = "\$text='เบอร์โทรศัพท์ที่ทำงาน:';";
$trans["mbrFldsEmail"]            = "\$text='อีเมล:';";
$trans["mbrFldsClassify"]         = "\$text='ประเภทสมาชิก:';";
$trans["mbrFldsStatus"]           = "\$text='สถานะ:';";
$trans["mbrFldsGrade"]            = "\$text='หน่วยงานที่ทำงาน:';";
$trans["mbrFldsTeacher"]          = "\$text='สถาบันที่ศึกษา:';";
$trans["mbrFldsSubmit"]           = "\$text='บันทึก';";
$trans["mbrFldsCancel"]           = "\$text='ยกเลิก';";
$trans["mbrsearchResult"]         = "\$text='หน้าแสดงผล: ';";
$trans["mbrsearchprev"]           = "\$text='ก่อนหน้านี้';";
$trans["mbrsearchnext"]           = "\$text='หน้าถัดไป';";
$trans["mbrsearchNoResults"]      = "\$text='ไม่พบผลการค้น.';";
$trans["mbrsearchFoundResults"]   = "\$text=' รายการค้นพบ.';";
$trans["mbrsearchSearchResults"]  = "\$text='ผลการค้น:';";
$trans["mbrsearchCardNumber"]     = "\$text='เลขที่สมาชิก:';";
$trans["mbrsearchClassification"] = "\$text='ประเภท:';";
$trans["mbrsearchStatus"]         = "\$text='สถานะ:';";
$trans["mbrActive"]               = "\$text='ปกติ';";
$trans["mbrInactive"]             = "\$text='ระงับ';";
$trans["mbrAutoBarcode"]          = "\$text='ใช้เลขที่สมาชิกอัตโนมัติ';";
$trans["mbrLatestBarcode"]        = "\$text='เลขที่สมาชิกล่าสุด';";
$trans["mbrViewLastActDate"]   = "\$text='ใช้งานล่าสุดเมื่อ:';";
$trans["mbrFormattedDate"]      = <<<INNERHTML

\$this_date = explode('-', date('D-j-m-Y-H:i', strtotime('%date%')));
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
  

  
\$text= \$this_date[1] . ' ' . \$thMonthLong[0+\$this_date[2]] . ' ' . (543 + \$this_date[3]) . ' - ' . \$this_date[4];

INNERHTML;

#****************************************************************************
#*  Translation text for page mbr_new.php
#****************************************************************************
$trans["mbrNewSuccess"]           = "\$text='เพิ่มสมาชิกสำเร็จ';";

#****************************************************************************
#*  Translation text for page mbr_edit.php
#****************************************************************************
$trans["mbrEditSuccess"]          = "\$text='แก้ไขสมาชิกสำเร็จ';";

#****************************************************************************
#*  Translation text for page mbr_view.php
#****************************************************************************
$trans["mbrViewHead1"]            = "\$text='ข้อมูลสมาชิก:';";
$trans["mbrViewName"]             = "\$text='ชื่อ:';";
$trans["mbrViewAddr"]             = "\$text='ที่อยู่:';";
$trans["mbrViewCardNmbr"]         = "\$text='เลขที่สมาชิก:';";
$trans["mbrViewClassify"]         = "\$text='ประเภทสมาชิก:';";
$trans["mbrViewPhone"]            = "\$text='เบอร์โทร:';";
$trans["mbrViewPhoneHome"]        = "\$text='บ้าน:';";
$trans["mbrViewPhoneWork"]        = "\$text='ทำงาน:';";
$trans["mbrViewEmail"]            = "\$text='อีเมล:';";
$trans["mbrViewGrade"]            = "\$text='School Grade:';";
$trans["mbrViewTeacher"]          = "\$text='Schooher:';";
$trans["mbrViewHead2"]            = "\$text='สถิติยืมออก:';";
$trans["mbrViewStatColHdr1"]      = "\$text='ประเภททรัพยากรสารสนเทศ';";
$trans["mbrViewStatColHdr2"]      = "\$text='ปัจจุบันยืม';";
$trans["mbrViewStatColHdr3"]      = "\$text='กำหนดสิทธิการยืม';";
$trans["mbrViewStatColHdr4"]      = "\$text='จำนวนยืมได้';";
$trans["mbrViewStatColHdr5"]      = "\$text='ยืมต่อ(ครั้ง)';";
$trans["mbrViewHead3"]            = "\$text='ใส่รหัสบาร์โค้ดที่ต้องการยืม:';";
$trans["mbrViewBarcode"]          = "\$text='รหัสบาร์โค้ด:';";
$trans["mbrViewCheckOut"]         = "\$text='ยืมออก';";
$trans["mbrViewHead4"]            = "\$text='ปัจจุบันรายการบรรณานุกรมที่ยืมออก:';";
$trans["mbrViewOutHdr1"]          = "\$text='ยืมออก';";
$trans["mbrViewOutHdr2"]          = "\$text='ประเภททรัพยากร';";
$trans["mbrViewOutHdr3"]          = "\$text='รหัสบาร์โค้ด';";
$trans["mbrViewOutHdr4"]          = "\$text='ชื่อเรื่อง';";
$trans["mbrViewOutHdr5"]          = "\$text='ผู้แต่ง';";
$trans["mbrViewOutHdr6"]          = "\$text='กำหนดคืน';";
$trans["mbrViewOutHdr7"]          = "\$text='เกินกำหนด';";
$trans["mbrViewOutHdr8"]          = "\$text='ยืมต่อ';";
$trans["mbrViewOutHdr9"]          = "\$text='ครั้ง';";
$trans["mbrViewNoCheckouts"]      = "\$text='ไม่มีรายการบรรณานุกรมถูกยืมออก';";
$trans["mbrViewHead5"]            = "\$text='จองสำหรับยืมต่อ:';";
$trans["mbrViewHead6"]            = "\$text='รายการทรัพยากรสารสนเทศที่จองเอาไว้:';";
$trans["mbrViewPlaceHold"]        = "\$text='จอง';";
$trans["mbrViewHoldHdr1"]         = "\$text='เปลี่ยนแปลง';";
$trans["mbrViewHoldHdr2"]         = "\$text='ถูกจอง';";
$trans["mbrViewHoldHdr3"]         = "\$text='ประเภททรัพยากรสารสนเทศ';";
$trans["mbrViewHoldHdr4"]         = "\$text='รหัสบาร์โค้ด';";
$trans["mbrViewHoldHdr5"]         = "\$text='ชื่อเรื่อง';";
$trans["mbrViewHoldHdr6"]         = "\$text='ผู้แต่ง';";
$trans["mbrViewHoldHdr7"]         = "\$text='สถานภาพ';";
$trans["mbrViewHoldHdr8"]         = "\$text='คืนทรัพยากรสารสนเทศ';";
$trans["mbrViewNoHolds"]          = "\$text='ไม่มีรายการบรรณานุกรมที่ถูกจอง';";
$trans["mbrViewBalMsg"]           = "\$text='หมายเหตุ: คุณยังมีค่าปรับยืมหนังสือเกินค้างอยู่จำนวน %bal%';";
$trans["mbrViewBalMsg2"]          = "\$text = 'หมายเหตุ: หนังสือเล่มนี้มีค่าปรับที่ต้องชำระจำนวน %fee%';";
$trans["mbrPrintCheckouts"]       = "\$text='พิมพ์รายการยืมออก';";
$trans["mbrViewDel"]              = "\$text='ลบ';";
$trans["mbrViewStatus"]           = "\$text='สถานะ:';";

#****************************************************************************
#*  Translation text for page checkout.php
#****************************************************************************
$trans["checkoutBalErr"]          = "\$text='ต้องจ่ายค่าปรับเกินกำหนดก่อนจึงสามารถยืมออกได้';";
$trans["checkoutErr1"]            = "\$text='Barcode number must be all alphanumeric.';";
$trans["checkoutErr2"]            = "\$text='ไม่พบรหัสบาร์โค้ดต้องการยืมออก';";
$trans["checkoutErr3"]            = "\$text=' %barcode% ถูกยืมออกอยู่ในขณะนี้';";
$trans["checkoutErr4"]            = "\$text=' %barcode% ไม่สามารถยืมออกได้';";
$trans["checkoutErr5"]            = "\$text=' %barcode% ปัจจุบันถูกจองสำหรับยืมตัวโดยสมาชิกคนอื่น';";
$trans["checkoutErr6"]            = "\$text='สมาชิกถูกจำกัดการยืมจากประเภททรัพยากรสารสนเทศพิเศษ';";
$trans["checkoutErr7"]            = "\$text=' %barcode% ถูกจำกัดสิทธิการยืมต่อ';";
$trans["checkoutErr8"]            = "\$text=' %barcode% ยืมเกินกำหนดไม่สามารถยืมต่อได้';";
$trans["checkoutErr9"]            = "\$text='สมาชิกถูกระงับการใช้งาน ไม่สามารถทำรายการได้';";

#****************************************************************************
#*  Translation text for page shelving_cart.php
#****************************************************************************
$trans["shelvingCartErr1"]        = "\$text='อาจจะต้องใส่ทั้งตัวเลขและตัวอักษร';";
$trans["shelvingCartErr2"]        = "\$text='ไม่พบรหัสบาร์โค้ดนี้';";
$trans["shelvingCartErr3"]        = "\$text='สำเนาชิ้นนี้ยังไม่ถูกยืมออกไป';";
$trans["shelvingCartTrans"]       = "\$text='ค่าปรับล่าสุด (barcode=%barcode%)';";

#****************************************************************************
#*  Translation text for page checkin_form.php
#****************************************************************************
$trans["checkinFormHdr1"]         = "\$text='คืนทรัพยากรสารสนเทศ:';";
$trans["checkinFormBarcode"]      = "\$text='รหัสบาร์โค้ด:';";
$trans["checkinFormShelveButton"] = "\$text='ตกลงคืน';";
$trans["checkinFormCheckinLink1"] = "\$text='คืนเฉพาะรายการที่เลือก';";
$trans["checkinFormCheckinLink2"] = "\$text='คืนรายการทั้งหมด';";
$trans["checkinFormHdr2"]         = "\$text='รายการคืนรอทำการขึ้นชั้นเพื่อให้บริการ:';";
$trans["checkinFormColHdr1"]      = "\$text='คืนเวลา';";
$trans["checkinFormColHdr2"]      = "\$text='รหัสบาร์โค้ด';";
$trans["checkinFormColHdr3"]      = "\$text='ชื่อเรื่อง';";
$trans["checkinFormColHdr4"]      = "\$text='ผู้แต่ง';";
$trans["checkinFormEmptyCart"]    = "\$text='ไม่มีรายการบรรณานุกรมสำหรับรอทำการขึ้นชั้นในขณะนี้';";
$trans["checkinDone1"]                  = "\$text='สมาชิก %fname% %lname% คืนสำเนารหัส %barcode% เรียบร้อยแล้ว';";
$trans["checkinDone2"]                  = "\$text='คืนสำเนารหัส %barcode% เรียบร้อยแล้ว';";

#****************************************************************************
#*  Translation text for page checkin.php
#****************************************************************************
$trans["checkinErr1"]             = "\$text='ไม่มีรหัสบาร์โค้ดให้เลือกคืน';";

#****************************************************************************
#*  Translation text for page hold_message.php
#****************************************************************************
$trans["holdMessageHdr"]          = "\$text='สำเนานี้ถูกจองไว้!';";
$trans["holdMessageMsg1"]         = "\$text='สำเนาทรัพยากรสารสนเทศรหัส %barcode% ที่กำลังทำรายการคืน มีสมาชิกจองเอาไว้ โปรดทำรายการสำเนานี้ต่อที่หน้า <b>รายงาน > รายการจองทรัพยากรสารสนเทศพร้อมข้อมูลสมาชิก</b><br />สถานะของสำเนาชิ้นนี้ถูกเปลี่ยนเป็น \"ถูกจอง\"';";
$trans["holdMessageMsg2"]         = "\$text='กลับไปรายการคืนทรัพยากรสารสนเทศ';";

#****************************************************************************
#*  Translation text for page place_hold.php
#****************************************************************************
$trans["placeHoldErr1"]           = "\$text='ต้องใส่ตัวเลขเท่านั้น';";
$trans["placeHoldErr2"]           = "\$text='ยังไม่สามารจองสำหรับยืมต่อได้';";
$trans["placeHoldErr3"]           = "\$text='สมาชิกนี้ยืมออกอยู่ขณะนี้ไม่สามารถจองต่อได้';";
$trans["placeHoldErrNotChkOut"]       = "\$text='รายการนี้ยังไม่ถูกยืมออกไป';";
$trans["placeHoldErrDup"]       = "\$text='สมาชิกคนนี้ได้แจ้งขอจองสำเนาของรายการนี้ไว้ก่อนแล้ว';";

#****************************************************************************
#*  Translation text for page mbr_del_confirm.php
#****************************************************************************
$trans["mbrDelConfirmWarn"]       = "\$text = 'Member, %name%, has %checkoutCount% checkout(s) and %holdCount% hold request(s).  All checked out materials must be checked in and all hold requests deleted before deleting this member.';";
$trans["mbrDelConfirmReturn"]     = "\$text = 'return to member information';";
$trans["mbrDelConfirmMsg"]        = "\$text = 'ยืนยันในการลบสมาชิกชื่อ %name% ';";

#****************************************************************************
#*  Translation text for page mbr_del.php
#****************************************************************************
$trans["mbrDelSuccess"]           = "\$text='สมาชิกชื่อ %name% ถูกลบ';";
$trans["mbrSuspendSuccess"]       = "\$text='สมาชิกชื่อ %name% ถูกระงับชั่วคราว';";
$trans["mbrDelReturn"]            = "\$text='กลับไปรายการค้นหาสมาชิก';";

#****************************************************************************
#*  Translation text for page mbr_history.php
#****************************************************************************
$trans["mbrHistoryHead1"]         = "\$text='ประวัติสมาชิกยืมออก:';";
$trans["mbrHistoryNoHist"]        = "\$text='ไม่พบประวัติ';";
$trans["mbrHistoryHdr1"]          = "\$text='รหัสบาร์โค้ด';";
$trans["mbrHistoryHdr2"]          = "\$text='ชื่อเรื่อง';";
$trans["mbrHistoryHdr3"]          = "\$text='ผู้แต่ง';";
$trans["mbrHistoryHdr4"]          = "\$text='สถานภาพใหม่';";
$trans["mbrHistoryHdr5"]          = "\$text='เปลี่ยนสถานะใหม่เมื่อ';";
$trans["mbrHistoryHdr6"]          = "\$text='กำหนดคืน';";

#****************************************************************************
#*  Translation text for page mbr_account.php
#****************************************************************************
$trans["mbrAccountLabel"]         = "\$text='เพิ่มรายการ:';";
$trans["mbrAccountTransTyp"]      = "\$text='ประเภทรายการ:';";
$trans["mbrAccountAmount"]        = "\$text='จำนวน:';";
$trans["mbrAccountDesc"]          = "\$text='รายละเอียด:';";
$trans["mbrAccountHead1"]         = "\$text='รายการค่าปรับ:';";
$trans["mbrAccountNoTrans"]       = "\$text='ไม่พบรายการ';";
$trans["mbrAccountOpenBal"]       = "\$text='รายงานทั้งหมด';";
$trans["mbrAccountDel"]           = "\$text='ลบ';";
$trans["mbrAccountHdr1"]          = "\$text='เปลี่ยนแปลง';";
$trans["mbrAccountHdr2"]          = "\$text='วัน';";
$trans["mbrAccountHdr3"]          = "\$text='ประเภท';";
$trans["mbrAccountHdr4"]          = "\$text='รายละเอียด';";
$trans["mbrAccountHdr5"]          = "\$text='จำนวน';";
$trans["mbrAccountHdr6"]          = "\$text='รวมค่าปรับทั้งหมด';";
$trans["mbrAccountLink"]           = "\$text='ดูรายการค่าปรับของสมาชิกท่านนี้';";

#****************************************************************************
#*  Translation text for page mbr_transaction.php
#****************************************************************************
$trans["mbrTransactionSuccess"]   = "\$text='รายการที่ทำสำเร็จ';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del_confirm.php
#****************************************************************************
$trans["mbrTransDelConfirmMsg"]   = "\$text='ยืนยันในการลบรายการ';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del.php
#****************************************************************************
$trans["mbrTransactionDelSuccess"] = "\$text='ลบรายการสำเร็จ';";

#****************************************************************************
#*  Translation text for page mbr_print_checkouts.php
#****************************************************************************
$trans["mbrPrintCheckoutsTitle"]  = "\$text='ยืมออกโดย %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"]   = "\$text='เมื่อ:';";
$trans["mbrPrintCheckoutsHdr2"]   = "\$text='สมาชิก:';";
$trans["mbrPrintCheckoutsHdr3"]   = "\$text='เลขที่สมาชิก:';";
$trans["mbrPrintCheckoutsHdr4"]   = "\$text='ประเภทสมาชิก:';";
$trans["mbrPrintCloseWindow"]     = "\$text='ปิดหน้าต่างนี้';";

#****************************************************************************
#*  Translation text for page csv_import.php, csv_export.php
#****************************************************************************
$trans["Export"]                      = "\$text='ส่งออก';";
$trans["CSVImportHeader"]     = "\$text='นำเข้ารายการสมาชิกจากไฟล์ CSV';";
$trans["CSVExportHeader"]     = "\$text='ส่งออกรายการสมาชิกเป็นไฟล์ CSV';";


# Error message
$trans["Card number is required."]  = "\$text = 'จำเป็นต้องกรอก เลขที่สมาชิก';";
$trans["Card number must be all alphabetic and numeric characters."] = "\$text = 'เลขที่สมาชิกต้องเป็นตัวอักษรภาษาอังกฤษและตัวเลขเท่านั้น';";
$trans["Last name is required."]       = "\$text = 'จำเป็นต้องกรอก ชื่อ';";
$trans["First name is required."]       = "\$text = 'จำเป็นต้องกรอก นามสกุล';";
$trans["Status options is incorrect."] = "\$text = 'ตัวเลือกสถานะสมาชิกไม่ถูกต้อง';";
?>
