<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "import_export";

  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE, $tab);

?>

<div class="box">
  <h1><?php echo $loc->getText("adminImport");?></h1>
  <ul>
    <li>
      <a href="/circ/csv_import.php"><?php echo $loc->getText("import_member_csv"); ?></a>
    </li>
    <li>
      <a href="/catalog/csv_import.php"><?php echo $loc->getText("import_bibliography_csv"); ?></a>
    </li>
  </ul>
</div>

<div class="box">
  <h1><?php echo $loc->getText("adminExport");?></h1>
  <ul>
    <li>
      <a href="/circ/csv_export.php"><?php echo $loc->getText("export_member_csv"); ?></a>
    </li>
    <li>
      <a href="/catalog/csv_export.php"><?php echo $loc->getText("export_bibliography_csv"); ?></a>
    </li>
  </ul>
</div>

<?php include("../shared/footer.php"); ?>
