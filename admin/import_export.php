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
    <li>
      <a href="/catalog/upload_usmarc_form.php"><?php echo $loc->getText("import_bibliography_marc"); ?></a>
    </li>
  </ul>
</div>

<div class="box">
  <h1><?php echo $loc->getText("adminExport");?></h1>
  <ul>
    <li>
      <form name="form_csv_export" method="POST" action="/shared/csv_export.php">
        <script type="text/javascript">
          function submit() {
            document.form_csv_export.submit();
          }
        </script>
        <a href="javascript:submit()"><?php echo $loc->getText("export_library_data_csv"); ?></a>
      </form>
    </li>
  </ul>
</div>

<?php include("../shared/footer.php"); ?>
