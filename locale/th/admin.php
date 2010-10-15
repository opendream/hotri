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
$trans["adminSubmit"]              = "\$text = 'บันทึก';";
$trans["adminCancel"]              = "\$text = 'ยกเลิก';";
$trans["adminDelete"]              = "\$text = 'ลบ';";
$trans["adminUpdate"]              = "\$text = 'ปรับปรุง';";
$trans["adminFootnote"]            = "\$text = 'เครื่องหมาย %symbol% บังคับใส่ข้อมูล';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'งานดูแลระบบ';";
$trans["indexDesc"]                = "\$text = 'ใช้เมนูด้านซ้ายสำหรับการาตั้งค่าระบบห้องสมุด';";

#****************************************************************************
#*  Translation text for page collections*.php
#****************************************************************************
$trans["adminCollections_delReturn"]                 = "\$text = 'กลับสู่รายการสถานที่จัดเก็บ';";
$trans["adminCollections_delStart"]                 = "\$text = 'สถานที่จัดเก็บ, ';";

#****************************************************************************
#*  Translation text for page collections_del.php
#****************************************************************************
$trans["adminCollections_delEnd"]                 = "\$text = ', ถูกลบ.';";

#****************************************************************************
#*  Translation text for page collections_del_confirm.php
#****************************************************************************
$trans["adminCollections_del_confirmText"]                 = "\$text = 'ยืนยันในการลบสถานที่จัดเก็บ ';";

#****************************************************************************
#*  Translation text for page collections_edit.php
#****************************************************************************
$trans["adminCollections_editEnd"]                 = "\$text = ',ถูกแก้ไข';";

#****************************************************************************
#*  Translation text for page collections_edit_form.php
#****************************************************************************
$trans["adminCollections_edit_formEditcollection"]                 = "\$text = 'แก้ไขสถานที่จัดเก็บ:';";
$trans["adminCollections_edit_formDescription"]                 = "\$text = 'รายระเอียด:';";
$trans["adminCollections_edit_formDaysdueback"]                 = "\$text = 'จำนวนวันที่ยืมได้:';";
$trans["adminCollections_edit_formDailyLateFee"]                 = "\$text = 'ค่าปรับเกินกำหนดต่อวัน:';";
$trans["adminCollections_edit_formNote"]                 = "\$text = '*หมายเหตุ:';";
$trans["adminCollections_edit_formNoteText"]                 = "\$text = 'ตั้งค่าวันที่ยืมได้เป็น 0 ไม่สามารถยืมได้';";

#****************************************************************************
#*  Translation text for page collections_list.php
#****************************************************************************
$trans["adminCollections_listAddNewCollection"]                 = "\$text = 'เพิ่มสถานที่จัดเก็บ';";
$trans["adminCollections_listCollections"]                 = "\$text = 'สถานที่จัดเก็บ:';";
$trans["adminCollections_listFunction"]                 = "\$text = 'คำสั่ง';";
$trans["adminCollections_listDescription"]                 = "\$text = 'รายละเอียด';";
$trans["adminCollections_listDaysdueback"]                 = "\$text = 'จำนวนวันที่ยืมได้';";
$trans["adminCollections_listDailylatefee"]                 = "\$text = 'ค่าปรับเกินกำหนดต่อวัน';";
$trans["adminCollections_listBibliographycount"]                 = "\$text = 'จำนวนทรัพยากรสารสนเทศทั้งหมด';";
$trans["adminCollections_listEdit"]                 = "\$text = 'แก้ไข';";
$trans["adminCollections_listDel"]                 = "\$text = 'ลบ';";
$trans["adminCollections_ListNote"]                 = "\$text = '*หมายเหตุ:';";
$trans["adminCollections_ListNoteText"]                 = "\$text = 'ถ้าต้องการลบสถานที่จัดเก็บจะต้องไม่มีรายการทรัพยากรอยู่สำหรับสถานที่จัดเก็บที่ต้องการลบ';";

#****************************************************************************
#*  Translation text for page collections_new.php
#****************************************************************************
$trans["adminCollections_newAdded"]                 = "\$text = ', ถูกเพิ่มเรียบร้อย';";

#****************************************************************************
#*  Translation text for page collections_new_form.php
#****************************************************************************
$trans["adminCollections_new_formAddnewcollection"]                 = "\$text = 'เพิ่มสถานที่จัดเก็บ:';";
$trans["adminCollections_new_formDescription"]                 = "\$text = 'รายละเอียด:';";
$trans["adminCollections_new_formDaysdueback"]                 = "\$text = 'จำนวนวันที่ยืมได้:';";
$trans["adminCollections_new_formDailylatefee"]                 = "\$text = 'ค่าปรับเกินกำหนด:';";
$trans["adminCollections_new_formNote"]                 = "\$text = '*หมายเหตุ:';";
$trans["adminCollections_new_formNoteText"]                 = "\$text = 'ตั้งค่าวันที่ยืมได้เป็น 0 ไม่สามารถยืมได้';";

#****************************************************************************
#*  Translation text for page materials_del.php
#****************************************************************************
$trans["admin_materials_delMaterialType"]                 = "\$text = 'ประเภททรัพยากรสารสนเทศ, ';";
$trans["admin_materials_delMaterialdeleted"]                 = "\$text = ', ถูกลบเรียบร้อย';";
$trans["admin_materials_Return"]                 = "\$text = 'กลับสู่รายการประเภททรัพยากรสารสนเทศ';";

#****************************************************************************
#*  Translation text for page materials_del_form.php
#****************************************************************************
$trans["admin_materials_delAreyousure"]                 = "\$text = 'ยืนยันในการลบประเภททรัพยากรสารสนเทศ ';";

#****************************************************************************
#*  Translation text for page materials_edit_form.php
#****************************************************************************
$trans["admin_materials_delEditmaterialtype"]                 = "\$text = 'แก้ไขประเภททรัพยากรสารสนเทศ:';";
$trans["admin_materials_delDescription"]                 = "\$text = 'ประเภททรัพยากรสารสนเทศ:';";
$trans["admin_materials_delunlimited"]                 = "\$text = '(ใส่ 0 ไม่จำกัด)';";
$trans["admin_materials_delImagefile"]                 = "\$text = 'ไฟล์รูปภาพ:';";
$trans["admin_materials_delNote"]                 = "\$text = '*หมายเหตุ:';";
$trans["admin_materials_delNoteText"]                 = "\$text = 'ต้องระบุชื่อไฟล์รูปภาพใน Directoty ชื่อ openbiblio/images';";

#****************************************************************************
#*  Translation text for page materials_edit.php
#****************************************************************************
$trans["admin_materials_editEnd"]                 = "\$text = ', ถูกแก้ไข';";

#****************************************************************************
#*  Translation text for page materials_list.php
#****************************************************************************
$trans["admin_materials_listAddmaterialtypes"]                 = "\$text = 'เพิ่มประเภททรัพยากรสารสนเทศ';";
$trans["admin_materials_listMaterialtypes"]                 = "\$text = 'ประเภททรัพยากรสารสนเทศ';";
$trans["admin_materials_listFunction"]                 = "\$text = 'คำสั่ง';";
$trans["admin_materials_listDescription"]                 = "\$text = 'ประเภททรัพยากรสารสนเทศ';";
$trans["admin_materials_listLimits"]                 = "\$text = 'จำกัด';";
$trans["admin_materials_listCheckoutlimit"]                 = "\$text = 'ยืมออก';";
$trans["admin_materials_listRenewallimit"]                 = "\$text = 'ยืมต่อ';";
$trans["admin_materials_listImageFile"]                 = "\$text = 'ชื่อไฟล์รูปภาพ';";
$trans["admin_materials_listBibcount"]                 = "\$text = 'รายการทรัพยากรสารสนเทศทั้งหมด';";
$trans["admin_materials_listEdit"]                 = "\$text = 'แก้ไข';";
$trans["admin_materials_listDel"]                 = "\$text = 'ลบ';";
$trans["admin_materials_listNote"]                 = "\$text = '*หมายเหตุ:';";
$trans["admin_materials_listNoteText"]                 = "\$text = 'ถ้าต้องการลบรายการประเภททรัพยากรสารสนเทศจะต้องไม่มีรายการทรัพยากรอยู่สำหรับประเภททรัพยากรที่ต้องการลบ';";

#****************************************************************************
#*  Translation text for page materials_new.php
#****************************************************************************
$trans["admin_materials_listNewadded"]                 = "\$text = ', ถูกเพิ่มเรียบร้อย';";

#****************************************************************************
#*  Translation text for page materials_new_form.php
#****************************************************************************
$trans["admin_materials_new_formNoteText"]                 = "\$text = 'ต้องระบุชื่อไฟล์รูปภาพใน Directoty ชื่อ openbiblio/images.';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["admin_noauth"]                 = "\$text = 'คุณไม่มีสิทธิ์สำหรับการใช้งานส่วนนี้';";

#****************************************************************************
#*  Translation text for page settings_edit.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page settings_edit_form.php
#****************************************************************************
$trans["admin_settingsUpdated"]                 = "\$text = 'ข้อมูลถูกปรับปรุงเรียบร้อยแล้ว';";
$trans["admin_settingsEditsettings"]                 = "\$text = 'แก้ไขการตั้งค่าห้องสมุด:';";
$trans["admin_settingsLibName"]                 = "\$text = 'ชื่อห้องสมุด:';";
$trans["admin_settingsLibimageurl"]                 = "\$text = 'ชื่อนามสกุลไฟล์รูปภาพส่วนหัวของระบบ:';";
$trans["admin_settingsOnlyshowimginheader"]                 = "\$text = 'แสดงรูปภาพส่วนหัวเท่านั้น:';";
$trans["admin_settingsLibhours"]                 = "\$text = 'เวลาเปิดทำการ:';";
$trans["admin_settingsLibphone"]                 = "\$text = 'ติดต่อ:';";
$trans["admin_settingsLibURL"]                 = "\$text = 'เว็บไซต์ห้องสมุด:';";
$trans["admin_settingsOPACURL"]                 = "\$text = 'URL ระบบ OPAC:';";
$trans["admin_settingsSessionTimeout"]                 = "\$text = 'เวลาอยู่ในระบบ:';";
$trans["admin_settingsMinutes"]                 = "\$text = 'นาที';";
$trans["admin_settingsSearchResults"]                 = "\$text = 'ผลการสืบค้น:';";
$trans["admin_settingsItemsperpage"]                 = "\$text = 'รายการต่อหน้า';";
$trans["admin_settingsPurgebibhistory"]                 = "\$text = 'ลบประวัติรายการบรรณานุกรมหลังจาก:';";
$trans["admin_settingsmonths"]                 = "\$text = 'เดือน';";
$trans["admin_settingsBlockCheckouts"]                 = "\$text = 'มีค่าปรับไม่สามารถยืมออกได้:';";
$trans["admin_settingsLocale"]                 = "\$text = 'ภาษา:';";
$trans["admin_settingsHTMLChar"]                 = "\$text = 'ชุดอักขระ HTML:';";
$trans["admin_settingsHTMLTagLangAttr"]                 = "\$text = 'ค่าภาษาในแท็ก HTML:';";
$trans["admin_settingsFontNormal"]                  = "\$text = 'Fonts สำหรับพิมพ์เอกสาร (ทั่วไป):';";
$trans["admin_settingsFontBold"]                  = "\$text = 'Fonts สำหรับพิมพ์เอกสาร (ตัวหนา):';";
$trans["admin_settingsFontOblique"]                  = "\$text = 'Fonts สำหรับพิมพ์เอกสาร (ตัวเอียง):';";
$trans["Max. hold length:"]                              = "\$text = 'ระยะเวลาสูงสุดในการจอง:';";
$trans["Add new member classificaiton"]       = "\$text = 'เพิ่มกลุ่มสมาชิก';";

#****************************************************************************
#*  Translation text for all staff pages
#****************************************************************************
$trans["adminStaff_Staffmember"]                 = "\$text = 'จัดการผู้ใช้งานระบบ,';";
$trans["adminStaff_Return"]                 = "\$text = 'กลับสู่รายการผู้ใช้งานระบบ;";
$trans["adminStaff_Yes"]                 = "\$text = 'อนุญาต';";
$trans["adminStaff_No"]                 = "\$text = 'ไม่อนุญาต';";


#****************************************************************************
#*  Translation text for page staff_del.php
#****************************************************************************
$trans["adminStaff_delDeleted"]                 = "\$text = ', ถูกลบ';";

#****************************************************************************
#*  Translation text for page staff_delete_confirm.php
#****************************************************************************
$trans["adminStaff_del_confirmConfirmText"]                 = "\$text = 'ยืนยันลบรายการผู้ใช้งานระบบ ';";

#****************************************************************************
#*  Translation text for page staff_edit.php
#****************************************************************************
$trans["adminStaff_editUpdated"]                 = "\$text = ', ถูกแก้ไข';";

#****************************************************************************
#*  Translation text for page staff_edit_form.php
#****************************************************************************
$trans["adminStaff_edit_formHeader"]                 = "\$text = 'แก้ไขข้อมูลผู้ใช้งานระบบ:';";
$trans["adminStaff_edit_formLastname"]                 = "\$text = 'ชื่อ';";
$trans["adminStaff_edit_formFirstname"]                 = "\$text = 'นามสกุล';";
$trans["adminStaff_edit_formLogin"]                 = "\$text = 'ชื่อเข้าใช้งานระบบ';";
$trans["adminStaff_edit_formAuth"]                 = "\$text = 'ระดับการใช้โมดูล';";
$trans["adminStaff_edit_formCirc"]                 = "\$text = 'ยืม-คืน';";
$trans["adminStaff_edit_formUpdatemember"]                 = "\$text = 'แก้ไขรายการสมาชิกห้องสมุด';";
$trans["adminStaff_edit_formCatalog"]                 = "\$text = 'รายการบรรณานุกรม';";
$trans["adminStaff_edit_formAdmin"]                 = "\$text = 'ส่วนดูแลระบบ';";
$trans["adminStaff_edit_formReports"]                 = "\$text = 'รายงาน';";
$trans["adminStaff_edit_formSuspended"]                 = "\$text = 'ระงับการใช้งานชั่วคราว';";

#****************************************************************************
#*  Translation text for page staff_list.php
#****************************************************************************
$trans["adminStaff_list_formHeader"]                 = "\$text = 'เพิ่มผู้ใช้งานระบบ';";
$trans["adminStaff_list_Columnheader"]                 = "\$text = ' ผู้ใช้งานระบบ:';";
$trans["adminStaff_list_Function"]                 = "\$text = 'คำสั่ง';";
$trans["adminStaff_list_Edit"]                 = "\$text = 'แก้ไข';";
$trans["adminStaff_list_Pwd"]                 = "\$text = 'รหัสผู้ใช้งาน';";
$trans["adminStaff_list_Del"]                 = "\$text = 'ลบ';";

#****************************************************************************
#*  Translation text for page staff_new.php
#****************************************************************************
$trans["adminStaff_new_Added"]                 = "\$text = ', ถูกเพิ่ม';";

#****************************************************************************
#*  Translation text for page staff_new_form.php
#****************************************************************************
$trans["adminStaff_new_form_Header"]          	= "\$text = 'เพิ่มผู้ใชงาน้ระบบใหม่:';";
$trans["adminStaff_new_form_Password"]          = "\$text = 'ใส่รหัสผู้ใช้งาน:';";
$trans["adminStaff_new_form_Reenterpassword"]   = "\$text = 'ยืนยันรหัสผู้ใช้งาน:';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset.php
#****************************************************************************
$trans["adminStaff_pwd_reset_Passwordreset"]   = "\$text = 'ใส่รหัสผู้ใช้งาน';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset_form.php
#****************************************************************************
$trans["adminStaff_pwd_reset_form_Resetheader"]   = "\$text = 'ใส่รหัสผู้ใช้งาน:';";

#****************************************************************************
#*  Translation text for theme pages
#****************************************************************************
$trans["adminTheme_Return"]                 = "\$text = 'กลับหน้ารายการหน้าจอระบบ';";
$trans["adminTheme_Theme"]                 = "\$text = 'หน้าจอระบบ ';";

#****************************************************************************
#*  Translation text for page theme_del.php
#****************************************************************************
$trans["adminTheme_Deleted"]                 = "\$text = ', ถูกลบ';";
#****************************************************************************
#*  Translation text for page theme_del_confirm.php
#****************************************************************************
$trans["adminTheme_Deleteconfirm"]                 = "\$text = 'ยืนยันการหน้าจอระบบ';";
#****************************************************************************
#*  Translation text for page theme_edit.php
#****************************************************************************
$trans["adminTheme_Updated"]                 = "\$text = ', ถูกปรับปรุง';";

#****************************************************************************
#*  Translation text for page theme_edit_form.php
#****************************************************************************
$trans["adminTheme_Preview"]                 = "\$text = 'ตัวอย่างการเปลี่ยนหน้าจอระบบ';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Changetheme"]                 = "\$text = 'เปลี่ยนหน้าจอระบบ';";
$trans["adminTheme_Choosetheme"]                 = "\$text = 'เลือกหน้าจอระบบ';";
$trans["adminTheme_Addnew"]                 = "\$text = 'เพิ่มหน้าจอระบบ';";
$trans["adminTheme_themes"]                 = "\$text = 'หน้าจอระบบ';";
$trans["adminTheme_function"]                 = "\$text = 'คำสั่ง';";
$trans["adminTheme_Themename"]                 = "\$text = 'ชื่อ';";
$trans["adminTheme_Usage"]                 = "\$text = 'การใช้';";
$trans["adminTheme_Edit"]                 = "\$text = 'แก้ไข';";
$trans["adminTheme_Copy"]                 = "\$text = 'คัดลอก';";
$trans["adminTheme_Del"]                 = "\$text = 'ลบ';";
$trans["adminTheme_Inuse"]                 = "\$text = 'ถูกใช้';";
$trans["adminTheme_Note"]                 = "\$text = '*หมายเหตุ:';";
$trans["adminTheme_Notetext"]                 = "\$text = 'ถ้าต้องการลบหน้าจอระบบ ปัจจุบันหน้าจอระบบต้องไม่ถูกใช้';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Theme2"]                 = "\$text = 'หน้าจอระบบ';";
$trans["adminTheme_Tablebordercolor"]                 = "\$text = 'สีเส้นขอบตาราง:';";
$trans["adminTheme_Errorcolor"]                 = "\$text = 'สีข้อผิดพลาด:';";
$trans["adminTheme_Tableborderwidth"]                 = "\$text = 'ความกว้างของเส้นขอบตาราง:';";
$trans["adminTheme_Tablecellpadding"]                 = "\$text = 'ความกว้างแท็บ:';";
$trans["adminTheme_Title"]                 = "\$text = 'ส่วนหัวระบบ';";
$trans["adminTheme_Mainbody"]                 = "\$text = 'ส่วนกลาง';";
$trans["adminTheme_Navigation"]                 = "\$text = 'เมนูซ้าย';";
$trans["adminTheme_Tabs"]                 = "\$text = 'เมนู';";
$trans["adminTheme_Backgroundcolor"]                 = "\$text = 'สีพื้น:';";
$trans["adminTheme_Fontface"]                 = "\$text = 'แบบอักษร:';";
$trans["adminTheme_Fontsize"]                 = "\$text = 'ขนาดอักษร:';";
$trans["adminTheme_Bold"]                 = "\$text = 'หนา';";
$trans["adminTheme_Fontcolor"]                 = "\$text = 'สีอักษร:';";
$trans["adminTheme_Linkcolor"]                 = "\$text = 'สีสำหรับการลิงค์:';";
$trans["adminTheme_Align"]                 = "\$text = 'ตำแหน่งแสดงผล:';";
$trans["adminTheme_Right"]                 = "\$text = 'ขวา';";
$trans["adminTheme_Left"]                 = "\$text = 'ซ้าย';";
$trans["adminTheme_Center"]                 = "\$text = 'กลาง';";

$trans["adminTheme_HeaderWording"]                 = "\$text = 'แก้ไข';";


#****************************************************************************
#*  Translation text for page theme_new.php
#****************************************************************************
$trans["adminTheme_new_Added"]                 = "\$text = ', ถูกเพิ่ม';";

#****************************************************************************
#*  Translation text for page theme_new_form.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page theme_preview.php
#****************************************************************************
$trans["adminTheme_preview_Themepreview"]                 = "\$text = 'ตัวอย่างหน้าจอระบบ';";
$trans["adminTheme_preview_Librarytitle"]                 = "\$text = 'ชื่อห้องสมุด';";
$trans["adminTheme_preview_CloseWindow"]                 = "\$text = 'ปิดหน้านี้';";
$trans["adminTheme_preview_Home"]                 = "\$text = 'หน้าหลัก';";
$trans["adminTheme_preview_Circulation"]   = "\$text = 'งานยืม - คืน';";
$trans["adminTheme_preview_Cataloging"]    = "\$text = 'งานลงรายการทรัพยากรสารสนเทศ';";
$trans["adminTheme_preview_Admin"]         = "\$text = 'งานดูแลระบบ';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'ลิงค์ตัวอย่าง';";
$trans["adminTheme_preview_Thisstart"]     = "\$text = 'แสดงของ ';";
$trans["adminTheme_preview_Thisend"]       = "\$text = 'หน้าจอระบบ';";
$trans["adminTheme_preview_Samplelist"]    = "\$text = 'รายการตัวอย่าง:';";
$trans["adminTheme_preview_Tableheading"]  = "\$text = 'Table Heading';";
$trans["adminTheme_preview_Sampledatarow1"]= "\$text = 'Sample data row 1';";
$trans["adminTheme_preview_Sampledatarow2"]= "\$text = 'Sample data row 2';";
$trans["adminTheme_preview_Sampledatarow3"]= "\$text = 'Sample data row 3';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'sample link';";
$trans["adminTheme_preview_Sampleerror"]   = "\$text = 'sample error';";
$trans["adminTheme_preview_Sampleinput"]   = "\$text = 'Sample Input';";
$trans["adminTheme_preview_Samplebutton"]  = "\$text = 'Sample Button';";
$trans["adminTheme_preview_Poweredby"]     = "\$text = 'Powered by OpenBiblio';";
$trans["adminTheme_preview_Copyright"]     = "\$text = 'Copyright &copy; 2002-2005 Dave Stevens';";
$trans["adminTheme_preview_underthe"]      = "\$text = 'under the';";
$trans["adminTheme_preview_GNU"]           = "\$text = 'GNU General Public License';";

#****************************************************************************
#*  Translation text for page theme_use.php
#****************************************************************************


#****************************************************************************
#*  Translation text for page lookupOptsForm.php
#****************************************************************************
$trans["lookup_opts"]       			     = "\$text = 'ตัวเลือกสำหรับ Z39.50';";
$trans["lookup_optsUpdated"]           = "\$text = 'แก้ไขการตั้งค่า Z39.50 แล้ว';";
$trans["lookup_optsSettings"]      		 = "\$text = 'แก้ไขตัวเลือกการค้นหาผ่าน Z39.50:';";
$trans["lookup_optsProtocol"]          = "\$text = 'โพรโตคอล:';";
$trans["lookup_optsMaxHits"]           = "\$text = 'จำนวนผลลัพธ์สูงสุดที่แสดง:';";
$trans["lookup_optsKeepDashes"]        = "\$text = 'คงเครื่องหมายขีด (-) ไว้ในผลลัพธ์:';";
$trans["lookup_optsCallNmbrType"]      = "\$text = 'ชนิดของเลขเรียกหนังสือ:';";
$trans["lookup_optsAutoDewey"]         = "\$text = 'Use Default Dewey:';";
$trans["lookup_optsDefaultDewey"]      = "\$text = 'Default Dewey Code:';";
$trans["lookup_optsAutoCutter"]        = "\$text = 'Generate Cutter if none:';";
$trans["lookup_optsCutterType"]        = "\$text = 'Cutter Type to create:';";
$trans["lookup_optsCutterWord"]        = "\$text = 'Dewey Cutter Word No.:';";
$trans["lookup_optsAutoCollection"]    = "\$text = 'Use Auto Collection:';";
$trans["lookup_optsFictionName"]       = "\$text = 'Fiction Collection Name:';";
$trans["lookup_optsFictionCode"]       = "\$text = 'Index no. of Fiction Code to use:';";
$trans["lookup_optsLocFictionCodes"]   = "\$text = 'LoC Fiction Codes';";
$trans["lookup_optsDewFictionCodes"]   = "\$text = 'Dewey Fiction codes:';";
$trans["lookup_callNmbrType"]          = "\$text = 'ชนิดของเลขเรียกหนังสือไม่ถูกต้อง!';";
$trans["lookup_optsUpdtBtn"]           = "\$text = 'ปรับปรุง';";
#****************************************************************************
#****************************************************************************
#*  Translation text for page lookupHostsForm.php
#****************************************************************************
$trans["lookup_hosts"]       			     = "\$text = 'เซิฟเวอร์ Z39.50';";
$trans["lookup_rqdNote"]       			 	 = "\$text = 'โปรดกรอกช่องที่บังคับทั้งหมด (*)';";
$trans["lookup_hostsUpdated"]          = "\$text = 'แก้ไขการตั้งค่าเซิฟเวอร์ Z39.50 แล้ว';";
$trans["lookup_hostsConfirmDelete"]    = "\$text = 'ยืนยันคำสั่งลบข้อมูลเซิฟเวอร์นี้หรือไม่?';";
$trans["lookup_hostsListFunction"]   	 = "\$text = 'Function';";
$trans["lookup_hostsListHeader"]       = "\$text = 'เซิฟเวอร์ทั้งหมด';";
$trans["lookup_hostsEditHeader"]       = "\$text = 'แก้ไขค่าต่างๆ ของเซิฟเวอร์';";
$trans["lookup_hostsNewHeader"]        = "\$text = 'กรอกคุณสมบัติของเซิฟเวอร์';";
$trans["lookup_hostsSeqNo"]    	     	 = "\$text = 'ลำดับ';";
$trans["lookup_hostsActive"]           = "\$text = 'เปิดใช้งาน';";
$trans["lookup_hostsHost"]       			 = "\$text = 'URL:port';";
$trans["lookup_hostsName"]     				 = "\$text = 'ชื่อ';";
$trans["lookup_hostsDb"]        			 = "\$text = 'ชื่อฐานข้อมูล';";
$trans["lookup_hostsUser"]      			 = "\$text = 'ชื่อผู้ใช้';";
$trans["lookup_hostsPw"]        			 = "\$text = 'รหัสผ่าน';";
$trans["lookup_hostsUpdtBtn"]          = "\$text = 'ปรับปรุง';";
#****************************************************************************
#* Improved translations
#****************************************************************************
$trans["Function"]        = "\$text = 'คำสั่ง';";
$trans["edit"]                = "\$text = 'แก้ไข';";
$trans["del"]                 = "\$text = 'ลบ';";
$trans["Description"]    = "\$text = 'รายละเอียด';";
$trans["Member Classifications List"]        = "\$text = 'รายชื่อกลุ่มสมาชิก';";
$trans["Members"]       = "\$text = 'จำนวนสมาชิก';";
$trans["Max. Fines"]     = "\$text = 'เพดานค่าปรับ';";

$trans["Custom Member Fields"]               = "\$text = 'ฟิลด์เพิ่มเติมของสมาชิก';";
$trans["Add new custom field"]                 = "\$text = 'เพิ่มฟิลด์ใหม่';";
?>
