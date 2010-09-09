<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/common.php");
$tab = "cataloging";
$nav = "";

require_once("../classes/Biblio.php");
require_once("../classes/BiblioField.php");
require_once("../classes/BiblioQuery.php");

require_once("../functions/fileIOFuncs.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

if (count($_FILES) == 0) {
  header("Location: upload_usmarc_form.php");
  exit();
}

include("../shared/header.php");

require_once("import_usmarc_excludes.php");

$recordterminator="\35";
$fieldterminator="\36";
$delimiter="\37";

$usmarc_str = fileGetContents($_FILES["usmarc_data"]["tmp_name"]);
// Detect & convert data.

$data = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $usmarc_str);
$encoding = mb_detect_encoding($data, mb_list_encodings());

if (strtoupper($encoding) != 'UTF-8') {
  $encoding_select = array("ASCII", "CP1256", "ISO-8859-1", "ISO-8859-6", "ISO-8859-15", "TIS-620", "UTF-8", "Windows-1252");
  $convert_from = $encoding_select[$_POST['encoding']];
  
  if (!empty($convert_from)) {
    $usmarc_str = iconv($convert_from, "UTF-8", $usmarc_str);
  }
  else { // Nothing selected, default convert to UTF-8.
    $convert_from = 'ISO-8859-1';
    $usmarc_str = utf8_encode($usmarc_str);
  }
  
  echo 'This data is not unicoded string & would be converted.';
  echo '<h3>Technical information:</h3>';
  echo '<p>Detected encoding: ' . $encoding . '<br />';
  echo 'Conversion: ' . $convert_from . ' > UTF-8<br /></p>';
}

$records = explode($recordterminator,$usmarc_str);
// We separated with a terminator, so the last element will always be empty.
array_pop($records);

$biblios = array();
foreach($records as $record) {
  $biblio = new Biblio();
  $biblio->setLastChangeUserid($_POST["userid"]);
  $biblio->setMaterialCd($_POST["materialCd"]);
  $biblio->setCollectionCd($_POST["collectionCd"]);
  $biblio->setOpacFlg($_POST["opac"] == 'Y');

  $start=substr($record,12,5);
  $header=substr($record,24,$start-25);
  $codes = array();
  for ($l=0; $l<strlen($header); $l += 12) {
    $code=substr($header,$l,12);
    $codes[]=substr($code,0,3);
  }
  
  $j=0;
  foreach(split($fieldterminator,substr($record,$start)) as $field) {
    if ($codes[$j]{0} == '0' and $codes[$j]{1} == '0') {
      $j++;
      continue;  // We don't support control fields yet
    }
    // Skip three characters to drop indicators and the first delimiter.
    foreach(split($delimiter,substr($field, 3)) as $subfield) {
      $ident = $subfield{0};
      $data=substr($subfield,1);

      if (in_array($codes[$j].$ident, $exclude)) {
        continue;
      }

      //echo H("$codes[$j]--$ident--$data")."<br />\n";

      if (trim($data)!="" and trim($codes[$j])!=="") {
        $f = new BiblioField();
        $f->setTag($codes[$j]);
        $f->setSubfieldCd($ident);
        $f->setFieldData($data);
        $biblio->addBiblioField($codes[$j].$ident, $f);
      }
    }
    $j++;
  }
  array_push($biblios, $biblio);
}

if ($_POST["test"]=="true") {
  if (count($biblios) > 0) {
    echo '<a href="./upload_usmarc_form.php">Back</a>.<hr />';
    foreach ($biblios as $biblio) {
      echo '<h3>'.$loc->getText("MarcUploadMarcRecord").'</h3>';
      echo '<table><tr>';
      echo '<th>'.$loc->getText("MarcUploadTag").'</th>';
      echo '<th>'.$loc->getText("MarcUploadSubfield").'</th>';
      echo '<th>'.$loc->getText("MarcUploadData").'</th>';
      echo '</tr>';
      foreach ($biblio->getBiblioFields() as $field) {
        echo '<tr><td>'.H($field->getTag()).'</td>';
        echo '<td>'.H($field->getSubfieldCd()).'</td>';
        echo '<td>'.H($field->getFieldData()).'</td></tr>';
      }
      echo '</table>';
    }
  }
  else {
    echo '<h3>'.$loc->getText("MarcUploadNoRows").'</h3>';
    echo '<p>'.$loc->getText("MarcUploadNoRowsDesc").'</p>';
  }
  echo '<hr /><h3>'.$loc->getText("MarcUploadRawData").'</h3>';
  
  echo '<hr /><a href="./upload_usmarc_form.php">Back</a>.';
} else {
  $bq = new BiblioQuery();
  $bq->connect();
  if ($bq->errorOccurred()) {
    $bq->close();
    displayErrorPage($bq);
  }
  foreach ($biblios as $biblio) {
    if (!$bq->insert($biblio)) {
      $bq->close();
      displayErrorPage($bq);
    }
  }
  $bq->close();

  echo $loc->getText("MarcUploadRecordsUploaded");
  echo ": ".H(count($biblios));
}
	
include("../shared/footer.php");


function utf8_compliant($str) {
    if ( strlen($str) == 0 ) {
        return TRUE;
    }
    // If even just the first character can be matched, when the /u
    // modifier is used, then it's valid UTF-8. If the UTF-8 is somehow
    // invalid, nothing at all will match, even if the string contains
    // some valid sequences
    return (preg_match('/^.{1}/us',$str,$ar) == 1);
}
?>
