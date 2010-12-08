<?php
  require_once("../shared/common.php");
  $tab = "home";
  $nav = "license";

  include("../shared/header.php");
?>

<h1>Credits to Hotri Developers</h1>
<em>OpenBiblio core 0.6.0 <?php echo $headerLoc->getText("footerDatabaseVersion"); ?> <?php echo H(OBIB_DB_VERSION);?></em>
<br>
<?php echo $headerLoc->getText("footerCopyright"); ?> &copy; 2002-2005 Dave Stevens<br>


<?php
include("../shared/footer.php");
