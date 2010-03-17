<?php
$tab = "admin";
$nav = "BulkLookup";
$helpPage = "BulkLookup";
$cancelLocation = "../admin/index.php";
require_once("../shared/common.php");
require_once("../shared/logincheck.php");

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
<h1>Bulk ISBN Lookup</h1>
<h5 id="updateMsg">All items has been queue!</h5>
<span>status:</span> 
<span style="color:blue; padding: 3px 0">Update every 10 seconds</span>
<div id="bulkMsg"></div>
<script type="text/javascript">
getStatus = function() { 
  $('#bulkMsg').css('border', '1px solid #ccc').css('padding', '5px');
  $.get('BulkStatus.php', function(data) {
    if (data.length < 1000) { // otherwise redirect page happen.
      if (data.substring(0, 4) == 'DONE') {
        clearInterval(updateStatus);
        data = data.substring(4);
      }
      $('#bulkMsg').html(data);
    }
    else {
      $('#bulkMsg').html('Error occured, press F5 to refresh this page.');
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
<h1>Bulk ISBN Lookup</h1>
$warning
<form method="post" enctype="multipart/form-data" action="{$_SERVER["SCRIPT_NAME"]}">
  <label for="upload">Choose the ISBN list file (.txt, one per line):</label> <br />
  <input type="file" name="upload" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10000"/>
  <input type="submit" name="submit" class="button" value="Import" />
</form>

INNERHTML;

  include("../shared/footer.php");
}
