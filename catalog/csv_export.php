<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "cataloging";
  $nav = "csv_export";

  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE, $tab);

?>

<h1><?php echo $loc->getText("CSVExportHeader"); ?></h1>
<form method="POST" action="/shared/csv_export.php">
  <input type="hidden" name="table" value="biblio" />
  <input type="hidden" name="join" value="LEFT JOIN biblio_copy ON biblio.bibid=biblio_copy.bibid LEFT JOIN biblio_field ON biblio.bibid=biblio_field.bibid" />
  <input type="submit" value="<?php echo $loc->getText("Export"); ?>" class="button" />
</form>
