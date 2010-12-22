<?php
  require_once("../shared/common.php");
  $tab = "home";
  $nav = "credits";

  require_once("../classes/Localize.php");
  $navloc = new Localize(OBIB_LOCALE, "navbars");

  include("../shared/header.php");
?>

<h1><?php echo $navloc->getText("homeCreditsLink"); ?></h1>

<?php
  $lines = file("../credits.txt");
  foreach ($lines as $line_num => $line) {
    print $line . "<br />\n";
  }
?>

<?php
include("../shared/footer.php");
