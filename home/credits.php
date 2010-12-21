<?php
  require_once("../shared/common.php");
  $tab = "home";
  $nav = "credits";

  include("../shared/header.php");
?>

<h1>Credits</h1>

<?php
  $lines = file("../credits.txt");
  foreach ($lines as $line_num => $line) {
    print $line . "<br />\n";
  }
?>

<br />
<em>OpenBiblio core 0.6.0 <?php echo $headerLoc->getText("footerDatabaseVersion"); ?> <?php echo H(OBIB_DB_VERSION);?></em>
<br />
<?php echo $headerLoc->getText("footerCopyright"); ?> &copy; 2002-2005 Dave Stevens
<br />

<?php
include("../shared/footer.php");
