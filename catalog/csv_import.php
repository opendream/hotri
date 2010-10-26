<?php
$tab = "cataloging";
$nav = "CsvImport";
$helpPage = "CsvImport";
$cancelLocation = "../catalog/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

require_once("../shared/header.php");
if (isset($_POST['submit'])) {
  require_once("../classes/CsvImport.php");
  $ci = new CsvImport();
  $status = $ci->importFromCsv($_FILES['upload']);
  
  // Report.
  echo <<<INNERHTML
<h1>{$loc->getText('CSVImport')}</h1>

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
  echo <<<INNERHTML
<h1>{$loc->getText('CSVImport')}</h1>
<p>{$loc->getText('CSVImportSizeLimitNotes')}</p>
<form method="post" enctype="multipart/form-data" action="{$_SERVER["SCRIPT_NAME"]}">
  <label for="upload"><p>{$loc->getText('CSVLabel')}</p></label>
  <input type="file" name="upload" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
  <input type="submit" name="submit" class="button" value="{$loc->getText('UploadFile')}" />
</form>

INNERHTML;
}

include("../shared/footer.php");
