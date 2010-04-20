<?php
$tab = "cataloging";
$nav = "CsvImport";
$helpPage = "CsvImport";
$cancelLocation = "../catalog/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");

require_once("../shared/header.php");
if (isset($_POST['submit'])) {
  require_once("../classes/CsvImport.php");
  $ci = new CsvImport();
  $status = $ci->importFromCsv($_FILES['upload']);
  
  // Report.
  echo <<<INNERHTML
<h1>CSV Import</h1>
<h5 id="updateMsg">All items has been process!</h5>
<span>status:</span>

INNERHTML;

  if (isset($status['error'])) {
    if (isset($status['pos']))
      $status['error'] .= ' @ ' . $status['pos'];
    echo <<<INNERHTML
<div id="errorMsg">
Error: $status[error]<br />
<br /><a href="csv_import.php">continue import</a>
</div>
INNERHTML;
  }
  else {
    echo <<<INNERHTML
<div id="importMsg">
Done: $status[done], copy: $status[copy], failed: $status[failed]<br />
<br /><a href="csv_import.php">continue import</a>
</div>
INNERHTML;
  }
}
else {
  echo <<<INNERHTML
<h1>CSV Import</h1>
<form method="post" enctype="multipart/form-data" action="{$_SERVER["SCRIPT_NAME"]}">
  <label for="upload"><p>Choose CSV file (use <a href="csv_template.csv">this template</a>, more information see <a href="javascript:popSecondary('../shared/help.php?page=CsvImport')">this help</a>):</p></label>
  <input type="file" name="upload" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
  <input type="submit" name="submit" class="button" value="Import" />
</form>

INNERHTML;
}

include("../shared/footer.php");
