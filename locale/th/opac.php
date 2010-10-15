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
$trans["opac_Header"]        = "\$text='ระบบสืบค้นรายการทรัพยากรสารสนเทศห้องสมุด (OPAC) 
';";
$trans["opac_WelcomeMsg"]    = "\$text=
  'ท่านสามารถสืบค้นทรัพยากรสารสนเทศได้จากรายการข้างล่างนี้';";
$trans["opac_SearchTitle"]   = "\$text='สืบค้นรายการบรรณานุกรมโดยใส่คำที่ต้องจากประเภทคำค้นด้านล่างนี้';";
$trans["opac_Title"]         = "\$text='ชื่อเรื่อง';";
 $trans["opac_Author"]        = "\$text='ผู้แต่ง';";
 $trans["opac_Subject"]       = "\$text='หัวเรื่อง';";
$trans["opac_All"]           = "\$text='คำสำคัญ';";
 $trans["opac_Search"]        = "\$text='ค้นหา';";
$trans["opac_SearchInvert"]  = "\$text='เลือกทั้งหมด';";
$trans["opac_SearchColl"]    = "\$text='สถานที่จัดเก็บ';";
$trans["opac_SearchMat"]     = "\$text='ประเภททรัพยากรสารสนเทศ';";
$trans["opac_ISBN"]        = "\$text='ISBN';";
?>
