<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $tag input field tag
 * @param int $occur input field occurance if field is being entered as repeatable
 * @return void
 * @access public
 *********************************************************************************
 */
function printUsmarcText($tag,$subfieldCd,&$marcTags,&$marcSubflds,$showTagDesc, $opac = TRUE){
  $arrayIndex = sprintf("%03d",$tag).$subfieldCd;

  $descr = $marcSubflds[$arrayIndex]->getDescription();
  $subfieldSet = explode(' ', $descr, 2);
  if (($showTagDesc) 
    && (isset($marcTags[$tag]))
    && (isset($marcSubflds[$arrayIndex]))){
    if (!$opac) {
      echo $subfieldSet[0] . ' ';
    }
    echo H($marcTags[$tag]->getDescription());
    echo ' - ' . $subfieldSet[1];
    //echo H($marcTags[$tag]->getDescription());
    //echo " (".H($marcSubflds[$arrayIndex]->getDescription()).")";
  } elseif (isset($marcSubflds[$arrayIndex])){
    if (!$opac) {
      echo $subfieldSet[0] . ' ';
    }
    echo $subfieldSet[1];
  }
}

?>
