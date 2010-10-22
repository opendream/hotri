<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  $doing_install = true;
  require_once("../shared/common.php");
  
  if (count($_POST) == 0) {
    header("Location: ../install/index.php");
    exit();
  }

  require_once("../classes/InstallQuery.php");

  $locale = 'en';
  $installTestData = false;
  
  if (isset($_POST['locale'])) {
    if (!preg_match('/^[-_a-zA-Z0-9]+$/', $_POST['locale'])) {
      Fatal::internalError("Bad locale name.");
    }
    $locale = $_POST['locale'];
  }
  if (isset($_POST['installTestData'])) {
    $installTestData = ($_POST["installTestData"] == "yes");
  }
  
  include("../install/header.php");
?>
<br>
<h1>OpenBiblio Installation:</h1>

<?php

  // Create directories for book cover / cover lookup
  $cover_path = @mkdir("../" . COVER_PATH, 0777, TRUE);
  $tmp_path = @mkdir("../" . COVER_PATH_TMP, 0777, TRUE);
  
  if ($cover_path) {
    echo 'Create book cover directory successfully.<br />';
  }
  else if (is_dir('../' . COVER_PATH)) {
    if (is_writable('../' . COVER_PATH)) {
      echo 'Book cover directory already exists & work properly.<br />';
    }
    else {
      $force_chmod = @chmod('../' . COVER_PATH, 0777);
      if ($force_chmod) {
        echo 'Book cover directory is exists, force read/write access to exists one.<br />';
      }
      else {
        echo '<span style="color: red">Could not change access to exist cover directory! Please change ' . COVER_PATH . ' directory permission (chmod) to full access (777) manually.</span><br />';
        $isFailedSomeDir = TRUE;
      }
    }
  }
  else {
    echo '<span style="color: red">Could not create book cover directory! Please create new ' . COVER_PATH . ' directory & change permission (chmod) to full access (777) manually.</span><br />';
    $isFailedSomeDir = TRUE;
  }
  
  if ($tmp_path) {
    echo 'Create temporary cover lookup directory successfully.<br />';
  }
  else if (is_dir('../' . COVER_PATH_TMP)) {
    if (is_writable('../' . COVER_PATH_TMP)) {
      echo 'Temporay cover lookup directory already exists & work properly.<br />';
    }
    else {
      $force_chmod = @chmod('../' . COVER_PATH_TMP, 0777);
      if ($force_chmod) {
        echo 'Temporary cover lookup directory is exists, force read/write access to exists one.<br />';
      }
      else {
        echo '<span style="color: red">Could not change access to exist temporary cover lookup directory! Please change ' . COVER_PATH_TMP . ' directory permission (chmod) to full access (777) manually.</span><br />';
        $isFailedSomeDir = TRUE;
      }
    }
  }
  else {
    echo '<span style="color: red">Could not create temporary cover lookup directory! Please create new ' . COVER_PATH_TMP . ' directory & change permission (chmod) to full access (777) manually.</span><br />';
    $isFailedSomeDir = TRUE;
  }
  
  if ($isFailedSomeDir) {
    echo '<hr />
    <span style="color: red; font-weight: bold;">Installation has been interrupted, please fix issues above then try to <a href="./index.php">run installation again</a>.</span>';
    include("../install/footer.php");
    exit();
  }

  # testing connection and current version
  $installQ = new InstallQuery();
  $err = $installQ->connect_e();
  if ($err) {
    Fatal::dbError($e->sql, $e->msg, $e->dberror);
  }
  $version = $installQ->getCurrentDatabaseVersion();
  echo "Database connection is good.<br>\n";

  #************************************************************************************
  #* show warning message if database exists.
  #************************************************************************************
  if ($version) {
    if (!isset($_POST["confirm"]) or ($_POST["confirm"] != "yes")){
      ?>
        <form method="POST" action="../install/install.php">
        OpenBiblio (version <?php echo H($version);?>) is already installed.
        Are you sure you want to delete all library data and create new OpenBiblio
        tables?<br>
        <input type="hidden" name="confirm" value="yes">
        <input type="hidden" name="locale" value="<?php echo H($locale); ?>">
        <input type="hidden" name="installTestData" value="<?php if (isset($_POST["installTestData"])) echo "yes"; ?>">
        <input type="submit" value="Continue">
        <input type="button" onClick="self.location='../install/cancel_msg.php'" value="Cancel">
        </form>
      <?php
      $setQ->close();
      include("../install/footer.php");
      exit();
    }
  }
  echo "Building OpenBiblio tables, please wait...<br>\n";
  
  $installQ->freshInstall($locale, $installTestData);
  $installQ->close();

?>
<br>
OpenBiblio tables have been created successfully!<br>
<a href="../home/index.php">start using OpenBiblio</a>


<?php include("../install/footer.php"); ?>
