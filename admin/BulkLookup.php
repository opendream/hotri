<?php
$tab = "admin";
$nav = "BulkLookup";
$helpPage = "BulkLookup";
$cancelLocation = "../admin/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);
$navbar = new Localize(OBIB_LOCALE, 'navbars');

// Bulk Lookup Test
if (isset($_POST['submit'])) {
  
  require_once('../classes/BulkLookup.php');
  $lookup = new BulkLookup();
  $lookup->importISBN($_FILES['upload'], $isbnList);
  //$lookup->search($isbnList); // Done
  //$lookup->showResults();
  
  // View status
  require_once("../shared/header.php");
  echo <<<INNERHTML
<h1>{$navbar->getText('lookup_bulk')}</h1>
<h5 id="updateMsg">{$loc->getText('lookup_bulkQueue')}</h5>
{$loc->getText('lookup_bulkStatusHead')}
<div id="bulkMsg"></div>
<script type="text/javascript">
getStatus = function() { 
  $('#bulkMsg').css('border', '1px solid #ccc').css('padding', '5px');
  $.get('../lookup2/BulkStatus.php', function(data) {
    if (data.length < 1000) { // otherwise redirect page happen.
      if (data.substring(0, 4) == 'DONE') {
        clearInterval(updateStatus);
        data = data.substring(4);
      }
      $('#bulkMsg').html(data);
    }
    else {
      $('#bulkMsg').html('{$loc->getText('lookup_bulkStatusError')}');
    }
  });
};
getStatus();
var updateStatus = setInterval(getStatus, 10000);
</script>
INNERHTML;
  include("../shared/footer.php");
}
else {
  require_once("../shared/header.php");

  $cancelLocation = "../catalog/index.php";

  // Find host.
  require_once(dirname(__FILE__) . '/../lookup2/LookupHostsQuery.php');
  getHosts('active');
  $list = $postVars['hosts'];

  if (!is_array($list) || count($list) < 1) {
    $warning = "<h5 id=\"updateMsg\">No hosts found, import always be in the failed list.</h5>";
  }
  
  echo <<<INNERHTML
<h1>{$navbar->getText('lookup_bulk')}</h1>
$warning
<form method="post" enctype="multipart/form-data" action="{$_SERVER["SCRIPT_NAME"]}">
  <label for="upload">{$loc->getText('lookup_bulkNotes')}</label> <br />
  <input type="file" name="upload" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10000"/>
  <input type="submit" name="submit" class="button" value="{$loc->getText('Import')}" />
</form>

INNERHTML;

  include("../shared/footer.php");
}
