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
  echo '<hr /><h3>'.$loc->getText("MarcUploadRawData").'</h3>';
  echo '<pre>';
  readfile($_FILES["usmarc_data"]["tmp_name"]);
  echo '</pre>';
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

?>
