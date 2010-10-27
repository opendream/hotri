<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  $doing_install = true;
  require_once("../shared/common.php");
  
  require_once("../classes/UpgradeQuery.php");

  include("../install/header.php");
?>
<br>
<h1>OpenBiblio Upgrade:</h1>

<?php

  # testing connection and current version
  $upgradeQ = new UpgradeQuery();

  echo "Updating OpenBiblio tables, please wait...<br>\n";
  
  list($notices, $error) = $upgradeQ->performUpgrade_e();
  if ($error) {
    echo "<h1>Upgrade Failed</h1>";
    echo $error->toStr();
    echo '<span style="color: red; font-weight: bold;">Installation has been interrupted, please fix issues above then try to <a href="./index.php">run update again</a>';
    include("../install/footer.php");
    exit();
  }
  $upgradeQ->close();

?>
<br>
OpenBiblio tables have been updated successfully!<br>
<?php
if (!empty($notices)) {
  echo '<h2>NOTICE:</h2>';
  echo '<ul>';
  foreach ($notices as $n) {
    echo '<li>'.H($n).'</li>';
  }
  echo '</ul>';
}
?>
<a href="../home/index.php">start using OpenBiblio</a>


<?php include("../install/footer.php"); ?>
