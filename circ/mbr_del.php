<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "deletedone";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $mbrid = $_GET["mbrid"];
  $mbrName = $_GET["name"];

  #**************************************************************************
  #*  Delete library member
  #**************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if (isset($_GET["permanently"]) && $_GET["permanently"] == 1) {
    $mbrQ->delete($mbrid);
  } else {
    $mbrQ->inactive($mbrid);
  }
  $mbrQ->close();

  #**************************************************************************
  #*  Delete Member History
  #**************************************************************************
  if (isset($_GET["permanently"]) && $_GET["permanently"] == 1) {
    $histQ = new BiblioStatusHistQuery();
    $histQ->connect();
    if ($histQ->errorOccurred()) {
      $histQ->close();
      displayErrorPage($histQ);
    }
    if (!$histQ->deleteByMbrid($mbrid)) {
      $histQ->close();
      displayErrorPage($histQ);
    }
    $histQ->close();
  }

  #**************************************************************************
  #*  Delete Member Account
  #**************************************************************************
  if (isset($_GET["permanently"]) && $_GET["permanently"] == 1) {
    $transQ = new MemberAccountQuery();
    $transQ->connect();
    if ($transQ->errorOccurred()) {
      $transQ->close();
      displayErrorPage($transQ);
    }
    $trans = $transQ->delete($mbrid);
    if ($transQ->errorOccurred()) {
      $transQ->close();
      displayErrorPage($transQ);
    }
    $transQ->close();
  }

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
  if (isset($_GET["permanently"]) && $_GET["permanently"] == 1) {
    echo $loc->getText("mbrDelSuccess", array("name"=>$mbrName));
  } else {
    echo $loc->getText("mbrSuspendSuccess", array("name"=>$mbrName));
  }
  
?>
<br><br>
<a href="../circ/index.php"><?php echo $loc->getText("mbrDelReturn");?></a>
<?php require_once("../shared/footer.php"); ?>
