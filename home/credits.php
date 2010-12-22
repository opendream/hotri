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

<?php
include("../shared/footer.php");
