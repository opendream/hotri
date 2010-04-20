<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/*********************************************************************************
 * explodes a quoted string into words
 * @param string $str String to be exploded
 * @return stringArray
 * @access public
 *********************************************************************************
 */
function explodeQuoted($str, $extended = false) {
  if ($str == ""){
    $elements[]="";
    return $elements; 
  }

  $inQuotes=false;

  // Extended keyword with AND, OR, NOT clause.
  if ($extended) {
    // Raw: a% AND "b% c"
    $str = str_replace('%', '[percent_mrk]', $str);
    // a[percent_mrk] AND "b[percent_mrk] c"
    $str = str_ireplace(' and ', "%and%", $str);
    $str = str_ireplace(' or ', "%or%", $str);
    $str = str_ireplace(' not ', "%not%", $str);
    if (stripos($str, 'not ') === 0) 
      $str = '%not%' . substr($str, 4);
    // a[percent_mrk]%and%"b[percent_mrk] c"
    
    $find_end_quote = false;
    $start_pos = -1;
    
    while (($qpos = strpos($str, '"')) !== false) {
      if ($find_end_quote) {
        $qstr = substr($str, $start_pos, $qpos - $start_pos);
        $replace_qstr = str_replace(" ", "%space_bar%", $qstr);
        $replace_qstr = preg_replace("(%(not|and|or)%)", "%space_bar%$1%space_bar%", $replace_qstr);
        $str = str_replace($qstr, $replace_qstr, $str);
        $find_end_quote = false;
      }
      else {
        $start_pos = $qpos;
        $str = substr($str, 0, $qpos) . substr($str, $qpos + 1);
        $find_end_quote = true;
      }
    }
  }
  
  $words=explode(" ", $str);
  foreach($words as $word) { 
    if($inQuotes==true) { 
      // add word to the last element 
      $elements[sizeof($elements)-1].=" ".str_replace('"','',$word); 
      if($word[strlen($word)-1]=="\"") $inQuotes=false; 
    } else { 
      // create a new element 
      $elements[]=str_replace('"','',$word);
      if($word[0]=="\"" && $word[strlen($word)-1]!="\"") $inQuotes=true; 
    }
  } 
  return $elements; 
}

?>
