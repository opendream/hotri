<?php
$tab = "cataloging";
$nav = "csv_import";
$helpPage = "CsvImport";
$cancelLocation = "../catalog/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
require_once("../functions/inputFuncs.php");
$loc = new Localize(OBIB_LOCALE,$tab);

require_once("../shared/header.php");
if (isset($_POST['submit'])) {
  require_once("../classes/CsvImport.php");
  $ci = new CsvImport();
  $status = $ci->importFromCsv($_FILES['upload']);
  
  // Report.
  echo <<<INNERHTML
<h1>{$loc->getText('CSVImportHeader')}</h1>

INNERHTML;

  if (isset($status['error'])) {
    if (isset($status['pos']))
      $status['error'] .= ' @ ' . $status['pos'];
    echo <<<INNERHTML
<div id="errorMsg">
Error: {$status[error]}
</div>
<a href="csv_import.php">{$loc->getText('CSVImportContinue')}</a>

INNERHTML;
  }
  else {
    echo <<<INNERHTML
<h4 id="updateMsg">{$loc->getText('CSVImportSuccess')}</h4>
<div id="importMsg">
{$loc->getText('CSVImportStatus', array('done' => $status['done'], 'copy' => $status['copy'], 'failed' => $status['failed']))}<br />
<br /><a href="csv_import.php">{$loc->getText('CSVImportContinue')}</a>
</div>
INNERHTML;
  }
}
else {
?>
<h1><?php echo $loc->getText('CSVImportHeader'); ?></h1>
<p><?php echo $loc->getText('CSVImportSizeLimitNotes'); ?></p>
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
  <label for="upload"><p><?php echo $loc->getText('CSVLabel'); ?></p></label>
  <input type="file" name="upload" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>

  <hr />
  <b><?php echo $loc->getText('Defaults:'); ?></b>
  <table border=0>
    <tr>
      <td><?php echo $loc->getText("biblioFieldsCollection"); ?>:</td>
      <td><?php printSelect("collectionCd","collection_dm",$postVars); ?></td>
    </tr>
    <tr>
      <td><?php echo $loc->getText("biblioFieldsMaterialTyp"); ?>:</td>
      <td><?php printSelect("materialCd","material_type_dm",$postVars); ?></td>
    </tr>
    <tr>
      <td><?php echo $loc->getText("biblioFieldsOpacFlg"); ?>:</td>
      <td>
        <select name="opac" id="opac">
          <option value="Y"><?php echo $loc->getText("AnswerYes"); ?></option>
          <option value="N" selected><?php echo $loc->getText("AnswerNo"); ?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="hidden" name="userid" id="userid" value="<?php echo H($_SESSION["userid"])?>">
      </td>
    </tr>
  </table>

  <input type="submit" name="submit" class="button" value="<?php echo $loc->getText('UploadFile'); ?>" />
</form>

<?php
}

include("../shared/footer.php");
