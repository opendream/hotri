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
$trans["catalogSubmit"]            = "\$text = 'บันทึก';";
$trans["catalogCancel"]            = "\$text = 'ยกเลิก';";
$trans["catalogRefresh"]           = "\$text = 'เริ่มใหม่';";
$trans["catalogDelete"]            = "\$text = 'ลบ';";
$trans["catalogFootnote"]          = "\$text = 'เครื่องหมาย %symbol% บังคับใส่ข้อมูล.';";
$trans["AnswerYes"]                = "\$text = 'ใช่';";
$trans["AnswerNo"]                 = "\$text = 'ไม่';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'งานลงรายการบรรณานุกรม';";
$trans["indexBarcodeHdr"]          = "\$text = 'ค้นหาบรรณานุกรมจากบาร์โค้ด';";
$trans["indexBarcodeField"]        = "\$text = 'รหัสบาร์โค้ด';";
$trans["indexSearchHdr"]           = "\$text = 'ค้นหารายการบรรณานุกรมโดย ค้นจากคำ';";
$trans["indexTitle"]               = "\$text = 'ชื่อเรื่อง';";
$trans["indexAuthor"]              = "\$text = 'ผู้แต่ง';";
$trans["indexSubject"]             = "\$text = 'หัวเรื่อง';";
$trans["indexISBN"]                = "\$text = 'ISBN';";
$trans["indexAll"]                 = "\$text = 'คำสำคัญ';";
$trans["indexButton"]              = "\$text = 'ค้นหา';";
$trans["indexSearchInvert"]        = "\$text='เลือกทั้งหมด';";
$trans["indexSearchColl"]          = "\$text='สถานที่จัดเก็บ';";
$trans["indexSearchMat"]           = "\$text='ประเภททรัพยากรสารสนเทศ';";
 
 #****************************************************************************
 #*  Translation text for page biblio_fields.php
#****************************************************************************
$trans["biblioFieldsLabel"]        = "\$text = 'รายการบรรณานุกรม';";
$trans["biblioFieldsMaterialTyp"]  = "\$text = 'ประเภททรัพยากรสารสนเทศ';";
$trans["biblioFieldsCollection"]   = "\$text = 'สถานที่จัดเก็บ';";
$trans["biblioFieldsCallNmbr"]     = "\$text = 'เลขหมู่';";
$trans["biblioFieldsUsmarcFields"] = "\$text = 'ส่วนการลงรายการ Marc';";
$trans["biblioFieldsOpacFlg"]      = "\$text = 'แสดงใน OPAC';";
$trans["pictureDescription"]       = "\$text = 'ไฟล์รูปภาพต้องอยู่ในไดเรกทอรี openbiblio/pictures';";
#****************************************************************************
#*  Translation text for page biblio_new.php
#****************************************************************************
$trans["biblioNewFormLabel"]       = "\$text = 'เพิ่มใหม่';";
$trans["biblioNewSuccess"]         = "\$text = 'รายการบรรณานุกรมถูกสร้าง  เพิ่มรายการตัวเล่ม เลือก \"เพิ่มใหม่\"  \"เพิ่มรายการตัวเล่ม\"จากข้อมูลรายการตัวเล่มข้างล่างนี้.';";

#****************************************************************************
#*  Translation text for page biblio_edit.php
#****************************************************************************
$trans["biblioEditSuccess"]        = "\$text = 'เพิ่มรายการบรรณานุกรมสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_copy_new_form.php and biblio_copy_edit_form.php
#****************************************************************************
$trans["biblioCopyNewFormLabel"]   = "\$text = 'เพิ่มรายการตัวเล่ม';";
$trans["biblioCopyNewBarcode"]     = "\$text = 'รหัสบาร์โค้ด';";
$trans["biblioCopyNewDesc"]        = "\$text = 'รายละเอียด';";
$trans["biblioCopyNewAuto"]        = "\$text = 'สร้างบาร์โค้ดอัตโนมัติ';";
$trans["biblioCopyEditFormLabel"]  = "\$text = 'แก้ไขรายการตัวเล่ม';";
$trans["biblioCopyEditFormStatus"] = "\$text = 'สถานภาพ';";

#****************************************************************************
#*  Translation text for page biblio_copy_new.php
#****************************************************************************
$trans["biblioCopyNewSuccess"]     = "\$text = 'เพิ่มรายการตัวเล่มสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_copy_edit.php
#****************************************************************************
$trans["biblioCopyEditSuccess"]    = "\$text = 'แก้ไขรายการตัวเล่มสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_copy_del_confirm.php
#****************************************************************************
$trans["biblioCopyDelConfirmErr1"] = "\$text = 'ไม่สามารถรายการตัวเล่มได้.  คุณควรตรวจสอบสถานภาพรายการตัวเล่มก่อนลบ';";
$trans["biblioCopyDelConfirmMsg"]  = "\$text = 'คุณยืนยันที่จะลบรายการตัวเล่มกับรหัสบาร์โค้ด %barcodeNmbr% นี้หรือไม่';";

#****************************************************************************
#*  Translation text for page biblio_copy_del.php
#****************************************************************************
$trans["biblioCopyDelSuccess"]     = "\$text = 'รายการตัวเล่มกับบาร์โค้ด %barcode% ได้ทำการลบสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_marc_list.php
#****************************************************************************
$trans["biblioMarcListMarcSelect"] = "\$text = 'เพิ่มระเบียน MARC ใหม่';";
$trans["biblioMarcListHdr"]        = "\$text = 'ข้อมูลระเบียน MARC';";
$trans["biblioMarcListTbleCol1"]   = "\$text = 'เปลี่ยนแปลง';";
$trans["biblioMarcListTbleCol2"]   = "\$text = 'เขตข้อมูล';";
$trans["biblioMarcListTbleCol3"]   = "\$text = 'รายละเอียดเขตข้อมูล';";
$trans["biblioMarcListTbleCol4"]   = "\$text = 'ตัวบ่งชี้ 1';";
$trans["biblioMarcListTbleCol5"]   = "\$text = 'ตัวบ่งชี้ 2';";
$trans["biblioMarcListTbleCol6"]   = "\$text = 'รหัสเขตข้อมูลย่อย';";
$trans["biblioMarcListTbleCol7"]   = "\$text = 'คำอธิบาย';";
$trans["biblioMarcListTbleCol8"]   = "\$text = 'เนื้อหา';";
$trans["biblioMarcListNoRows"]     = "\$text = 'ไม่พบเขตข้อมูล MARC';";
$trans["biblioMarcListEdit"]       = "\$text = 'แก้ไข';";
$trans["biblioMarcListDel"]        = "\$text = 'ลบ';";

#****************************************************************************
#*  Translation text for page usmarc_select.php
#****************************************************************************
$trans["usmarcSelectHdr"]          = "\$text = 'เขตข้อมูล MARC';";
$trans["usmarcSelectInst"]         = "\$text = 'เลือกเขตข้อมูล';";
$trans["usmarcSelectNoTags"]       = "\$text = 'ไม่พบเขตข้อมูล';";
$trans["usmarcSelectUse"]          = "\$text = 'ใช้';";
$trans["usmarcCloseWindow"]        = "\$text = 'เปิดหน้าต่างนี้';";

#****************************************************************************
#*  Translation text for page biblio_marc_new_form.php
#****************************************************************************
$trans["biblioMarcNewFormHdr"]     = "\$text = 'เพิ่มระเบียน MARC ใหม่';";
$trans["biblioMarcNewFormTag"]     = "\$text = 'เขตข้อมูล';";
$trans["biblioMarcNewFormSubfld"]  = "\$text = 'รหัสเขตข้อมูลย่อย';";
$trans["biblioMarcNewFormData"]    = "\$text = 'ข้อมูลเขตข้อมูล';";
$trans["biblioMarcNewFormInd1"]    = "\$text = 'ตัวบ่งชี้ 1';";
$trans["biblioMarcNewFormInd2"]    = "\$text = 'ตัวบ่งชี้ 2';";
$trans["biblioMarcNewFormSelect"]  = "\$text = 'เลือก';";

#****************************************************************************
#*  Translation text for page biblio_marc_new.php
#****************************************************************************
$trans["biblioMarcNewSuccess"]     = "\$text = 'เพิ่มเขตข้อมูลสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_marc_edit_form.php
#****************************************************************************
$trans["biblioMarcEditFormHdr"]    = "\$text = 'แก้ไขเขตข้อมูล';";

#****************************************************************************
#*  Translation text for page biblio_marc_edit.php
#****************************************************************************
$trans["biblioMarcEditSuccess"]    = "\$text = 'แก้ไขเขตข้อมูลสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_marc_del_confirm.php
#****************************************************************************
$trans["biblioMarcDelConfirmMsg"]  = "\$text = 'ยืนยันสำหรับการลบเขตข้อมูล tag %tag% และรหัสเขตข้อมูล %subfieldCd%หรือไม่';";

#****************************************************************************
#*  Translation text for page biblio_marc_del.php
#****************************************************************************
$trans["biblioMarcDelSuccess"]     = "\$text = 'ลบเขตข้อมูลสำเร็จ';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelConfirmWarn"]     = "\$text = 'รายการบรรณานุกรมนี้มี %copyCount% รายการตัวเล่ม และ %holdCount%  ถูกจอง กรุณาลบรายการตัวเล่มและรายการจองก่อนลบรายการบรรณานุกรมนี้';";
$trans["biblioDelConfirmReturn"]   = "\$text = 'กลับหน้าข้อมูลรายการบรรณานุกรม';";
$trans["biblioDelConfirmMsg"]      = "\$text = 'ยืนยันในการลบรายการบรรณานุกรมชื่อเรื่อง %title%';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelMsg"]             = "\$text = 'รายการบรรณานุกรมชื่อเรื่อง %title% ถูกลบ';";
$trans["biblioDelReturn"]          = "\$text = 'กลับหน้าค้นรายการบรรณานุกรม';";

#****************************************************************************
#*  Translation text for page biblio_hold_list.php
#****************************************************************************
$trans["biblioHoldListHead"]       = "\$text = 'รายการบรรณานุกรมถูกจองสำหรับยืมต่อ:';";
$trans["biblioHoldListNoHolds"]    = "\$text = 'ไม่มีรายการตัวเล่มถูกจองสำหรับยืมต่อ';";
$trans["biblioHoldListHdr1"]       = "\$text = 'เปลี่ยนแปลง';";
$trans["biblioHoldListHdr2"]       = "\$text = 'รายการตัวเล่ม';";
$trans["biblioHoldListHdr3"]       = "\$text = 'เริ่มจองเมื่อ';";
$trans["biblioHoldListHdr4"]       = "\$text = 'สมาชิก';";
$trans["biblioHoldListHdr5"]       = "\$text = 'สถานภาพ';";
$trans["biblioHoldListHdr6"]       = "\$text = 'กำหนดคืน';";
$trans["biblioHoldListdel"]        = "\$text = 'ลบ';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["NotAuth"]                 = "\$text = 'คุณไม่มีสิทธิ์เข้าใช้ รายการบรรณานุกรม';";

#****************************************************************************
#*  Translation text for page upload_usmarc.php and upload_usmarc_form.php
#****************************************************************************
$trans["MarcUploadTest"]            = "\$text = 'ทดสอบนำเข้า';";
$trans["MarcUploadTestTrue"]        = "\$text = 'จริง';";
$trans["MarcUploadTestFalse"]       = "\$text = 'เท็จ';";
$trans["MarcUploadTestFileUpload"]  = "\$text = 'ใส่ไฟล์ Marc ';";
$trans["MarcUploadEncoding"]      = "\$text = 'ชนิดของรหัสอักขระ';";
$trans["MarcUploadRecordsUploaded"] = "\$text = 'รายการเพิ่ม';";
$trans["MarcUploadMarcRecord"]      = "\$text = 'ระเบียน MARC ';";
$trans["MarcUploadNoRows"]    = "\$text = 'ไม่มีข้อมูลใดๆ ที่แปลงออกมาได้';";
$trans["MarcUploadNoRowsDesc"] = "\$text = 'โปรดเลือกรหัสอักขระชนิดอื่นๆ ในการนำเข้าระเบียน MARC  <a href=\"./upload_usmarc_form.php\">ทดลองใหม่</a>.';";
$trans["MarcUploadTag"]             = "\$text = 'เขตข้อมูล';";
$trans["MarcUploadSubfield"]        = "\$text = 'รหัสเขตข้อมูลย่อย';";
$trans["MarcUploadData"]            = "\$text = 'ข้อมูล';";
$trans["MarcUploadRawData"]         = "\$text = 'ข้อมูลดิบ';";
 $trans["UploadFile"]                = "\$text = 'อัพโหลดไฟล์';";
 
 #****************************************************************************
#*  Translation text for page upload_csv(_form).php
#****************************************************************************
$trans["CSVloadTest"]            = "\$text = 'ทดสอบนำเข้า';";
$trans["CSVloadTestTrue"]        = "\$text = 'จริง';";
$trans["CSVloadTestFalse"]       = "\$text = 'เท็จ';";
$trans["CSVloadTestFileUpload"]  = "\$text = 'ใส่ไฟล์ CSV ';";
$trans["CSVloadRecordsUploaded"] = "\$text = 'Records Uploaded';";
$trans["CSVloadMarcRecord"]      = "\$text = 'CSV Record';";
$trans["CSVloadTag"]             = "\$text = 'เขตข้อมูล';";
$trans["CSVloadSubfield"]        = "\$text = 'รหัสเขตข้อมูลย่อย';";
$trans["CSVloadData"]            = "\$text = 'ข้อมูล';";
$trans["CSVRecordsRead"]         = "\$text = 'of %total% records read';";
$trans["CSVHeadings"]            = "\$text = 'Heading targets identified';";
$trans["CSVTargets"]             = "\$text = 'Target';";
$trans["CSVComments"]            = "\$text = 'Comment';";
$trans["CSVunknownIgnored"]      = "\$text = 'UNKNOWN (ignored)';";
$trans["CSVMaterialUnknown"]     = "\$text = 'Material &quot;%mType%&quot; unknown, will assume default';";
$trans["CSVCollUnknown"]         = "\$text = 'Material &quot;%collType%&quot; unknown, will assume default';";
$trans["CSVadded"]               = "\$text = 'เพิ่ม';";
$trans["CSVerrorAtRecord"]       = "\$text = 'มีข้อผิดพลาดการบีนทึก';";
$trans["CSVerrors"]              = "\$text = 'ผิดพลาด';";
$trans["CSVerror"]               = "\$text = 'ผิดพลาด';";
$trans["CSVwarning"]             = "\$text = 'ถูกเตือน';";
$trans["UploadFile"]             = "\$text = 'ไฟล์อัพโหลด';";
$trans["Defaults"]               = "\$text = 'ระบุ';";
$trans["CSVshowAllFiles"]        = "\$text = 'Show all records (disable on large files)';";
$trans["CSVcopyDescription"]     = "\$text = 'Text for descriptions of item copies';";
$trans["CSVinputDescr"]          = "\$text = 'The input file must be an tab separated text file (no text indication - &quot;&quot;) with exactly the target field names in the first row.';";
$trans["CSVimportAdvise"]        = "\$text = 'It is <b><u>STRONGLY RECOMMENDED</u></b> to run in test mode, first and have a database backup available before import!';";
$trans["CSVimportMoreMARC"]      = "\$text = 'All other MARC data can also be imported by use of the MARC tag (e.g. 020\$a for ISBN).';";
$trans["CSVcolumnHeading"]       = "\$text = 'หัวข้อ';";
$trans["CSVcolumnDescription"]   = "\$text = 'รายละเอียด';";
$trans["CSVcolumnComment"]       = "\$text = 'ข้อความ';";
$trans["CSVbarCoDescription"]    = "\$text = 'Optional. Can be used for an initial copy entry in case of migration.';";
$trans["CSVCallNumber"]          = "\$text = 'เลขหมู่';";
$trans["CSVCallNrDescription"]   = "\$text = 'Mandatory. Call2 and Call3 are optional.';";
$trans["Mandatory"]              = "\$text = 'Mandatory';";
$trans["CSVoptionalDefault"]     = "\$text = 'Optional. Overwrites default value as given in submit form.';";

#****************************************************************************
 #*  Translation text for page usmarc_select.php
 #****************************************************************************
 $trans["PoweredByOB"]                 = "\$text = 'Powered by OpenBiblio';";
$trans["Copyright"]                   = "\$text = 'Copyright &copy; 2002-2005';";
$trans["underthe"]                    = "\$text = 'under the';";
$trans["GNU"]                 = "\$text = 'GNU General Public License';";

$trans["catalogResults"]                 = "\$text = 'ผลการสืบค้น';";
#****************************************************************************
#*  Translation text for Amazon module
#****************************************************************************
$trans['amazon_Instructions']               = "\$text = 'ใส่คำค้นจาก ชื่อเรื่อง, ผู้แต่ง, ISBN และ Amazon Collection';";
$trans['amazon_Search']                     = "\$text = 'ค้นหาจาก Amazon.com';";
$trans['amazon_Title']                      = "\$text = 'ชื่อเรื่อง';";
$trans['amazon_Author']                     = "\$text = 'ผู้แต่ง';";
$trans['amazon_ISBN']                       = "\$text = 'ISBN';";
$trans['amazon_Publication']                = "\$text = 'Publication';";
$trans['amazon_Publisher']                  = "\$text = 'ผู้จัดพิมพ์';";
$trans['amazon_PublicationDate']            = "\$text = 'เริ่มจัดพิมพ์';";
$trans['amazon_UseThis']                    = "\$text = 'ใช้รายการนี้';";

$trans['Search']                            = "\$text = 'ค้นหา';";
#****************************************************************************
  #* Translation text for Library of Congress SRU module
  #****************************************************************************
  $trans['locsru_Instructions']               = "\$text = 'ใสคำค้น ชื่อเรื่อง, ผู้แต่ง, ISBN';";
  $trans['locsru_Search']                     = "\$text = 'ค้นหาจาก Library of Congress ';";
  $trans['locsru_Title']                      = "\$text = 'ชื่อเรื่อง';";
  $trans['locsru_Author']                     = "\$text = 'ผู้แต่ง';";
  $trans['locsru_ISBN']                       = "\$text = 'ISBN';";
  $trans['locsru_Publication']                = "\$text = 'สถานที่พิมพ์';";
  $trans['locsru_Publisher']                  = "\$text = 'ผู้จัดพิมพ์';";
  $trans['locsru_PublicationDate']            = "\$text = 'เริ่มจัดพิมพ์';";
  $trans['locsru_UseThis']                    = "\$text = 'ใช้รายการนี้';";
  
  $trans['Search']                            = "\$text = 'Search';";
  
#****************************************************************************
#*  Translation text for page lookup_form.php
#****************************************************************************
$trans["lookup_z3950Search"]     = "\$text = 'ค้นหาแบบออนไลน์';";
$trans["lookup_isbn"]            = "\$text = 'ISBN';";
$trans["lookup_issn"]            = "\$text = 'ISSN';";
$trans["lookup_lccn"]            = "\$text = 'LCCN';";
$trans["lookup_title"]           = "\$text = 'ชื่อเรื่อง';";
$trans["lookup_author"]          = "\$text = 'ผู้แต่ง';";
$trans["lookup_keyword"]         = "\$text = 'คีย์เวิร์ด';";
$trans["lookup_publisher"]       = "\$text = 'สำนักพิมพ์';";
$trans["lookup_pubLoc"]          = "\$text = 'สถานที่พิมพ์';";
$trans["lookup_pubDate"]         = "\$text = 'วันที่พิมพ์';";
$trans["lookup_andOpt"]          = "\$text = 'AND (ตัวเลือกเสริม)';";
$trans["lookup_search"]          = "\$text = 'ค้นหา';";
$trans["lookup_repository"]		   = "\$text = 'Repository';";
$trans["lookup_yazSetupFailed"]  = "\$text = 'การตั้งค่า YAZ ผิดพลาดที่โฮส: !';";
$trans["lookup_badQuery"]        = "\$text = 'คำสั่งคิวรีไม่ถูกต้อง';";
$trans["lookup_patience"]        = "\$text = 'ระบบกำลังค้นหาข้อมูล โปรดรอสักครู่';";
$trans["lookup_resetInstr"]      = "\$text = 'หากเกิน 30 วินาที กด F5 เพื่อลองใหม่';";
$trans["lookup_goBack"]  	       = "\$text = 'ย้อนกลับ';";
$trans["lookup_abandon"]  	     = "\$text = 'ยกเลิกการค้นหา';";
$trans["lookup_yazError"]        = "\$text = 'Lookup YAZ Error: ';";
$trans["lookup_nothingFound"]    = "\$text = 'ไม่มีผลการค้นหาที่ตรงกับ ';";
$trans["lookup_tooManyHits"]     = "\$text = 'ค้นพบผลลัพธ์มากเกินกว่าจะแสดงผลได้, ';";
$trans["lookup_refineSearch"]    = "\$text = 'โปรดปรับเปลี่ยนคำค้นและลองค้นหาใหม่อีกครั้ง';";
$trans["lookup_noResponse"]   = "\$text = 'เซิฟเวอร์ปลายทางไม่ตอบสนอง';";
$trans["lookup_success"]         = "\$text = 'การค้นหาผ่าน Z39.50 ได้ผลลัพธ์ดังนี้';";
$trans["lookup_hits"]            = "\$text = ' ผลลัพธ์ โปรดเลือกอันใดอันหนึ่ง';";
$trans["lookup_callNmbrType"]    = "\$text = 'Your my_callNmbrType is invalid!';";
$trans['lookup_useThis']         = "\$text = 'เลือกอันนี้';";
$trans['lookup_searchError']     = "\$text = 'SEARCH ERROR: โปรดแจ้งข้อมูลต่อไปนี้ให้กับผู้ดูแลระบบ:';";
$trans["lookup_EmptyKeyword"]   = "\$text = 'โปรดประบุคำค้นหา';";

$trans["locsru_Title"]                    = "\$text = 'ชื่อเรื่อง';";
$trans["locsru_Author"]                = "\$text = 'ผู้แต่ง';";
$trans["locsru_ISBN"]                   = "\$text = 'ISBN';";
$trans["locsru_Publication"]         = "\$text = 'สถานที่พิมพ์';";
$trans["locsru_Publisher"]            = "\$text = 'สำนักพิมพ์';";
$trans["locsru_PublicationDate"]  = "\$text = 'วันที่พิมพ์';";

#****************************************************************************

  
  ?>
