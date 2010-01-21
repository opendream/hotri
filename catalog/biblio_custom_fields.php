<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  #****************************************************************************
  #*  Loading up an array ($marcArray) with the USMarc tag descriptions.
  #****************************************************************************

  $marcTagDmQ = new UsmarcTagDmQuery();
  $marcTagDmQ->connect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTagDmQ->execSelect();
  if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
  }
  $marcTags = $marcTagDmQ->fetchRows();
  $marcTagDmQ->close();

  $marcSubfldDmQ = new UsmarcSubfieldDmQuery();
  $marcSubfldDmQ->connect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubfldDmQ->execSelect();
  if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
  }
  $marcSubflds = $marcSubfldDmQ->fetchRows();
  $marcSubfldDmQ->close();
  
  # Hack to get around the way printUsmarcInputText works
  class CustomDescr {
    function CustomDescr($descr) {
      $this->descr = $descr;
    }
    function getDescription() {
      return $this->descr;
    }
  }
  include_once("../classes/MaterialFieldQuery.php");
  $matQ = new MaterialFieldQuery();
  $matQ->connect();
  $rows = $matQ->get($materialCd);
  $matQ->close();
  $descrs = array();
  foreach ($rows as $row) {
    $mytag = $row["tag"];
    $mysubfieldcd = $row["subfieldCd"];
    $idx = sprintf('%03d%s', $mytag, $mysubfieldcd);
    $descrs[$idx] = new CustomDescr($row['descr']);
    if ($row["required"]=="Y") {
      $myrequired=TRUE;
    } else {
      $myrequired=FALSE;
    }
    $mycntrltype = $row["cntrltype"];
    $fldindex = "";
    printUsmarcInputText($mytag,$mysubfieldcd,$myrequired,$postVars,$pageErrors,$marcTags,$descrs,FALSE,$mycntrltype,$fldindex);
  }
?>

