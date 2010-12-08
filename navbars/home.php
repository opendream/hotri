<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");


 if (isset($_SESSION["userid"])) {
   $sess_userid = $_SESSION["userid"];
 } else {
   $sess_userid = "";
 }
 if ($sess_userid == "") { ?>
  <input type="button" onClick="self.location='../shared/loginform.php?RET=../home/index.php'" value="<?php echo $navLoc->getText("login");?>" class="navbutton">
<?php } else { ?>
  <input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php } ?>
<br /><br />

<ul>
<?php if ($nav == "home") { ?>
 <li class="active">
   <?php echo $navLoc->getText("homeHomeLink");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../home/index.php" class="alt1"><?php echo $navLoc->getText("homeHomeLink");?></a>
 </li>
<?php } 
// Temporary disable frontpage feature, wait for new options for switching on/off.
// <a href="../front/" class="alt1"><?php echo $navLoc->getText("Front Page"); ? ></a><br />
?>
<?php if ($nav == "license") { ?>
 <li class="active">
   <?php echo $navLoc->getText("homeLicenseLink");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../home/license.php" class="alt1"><?php echo $navLoc->getText("homeLicenseLink");?></a>
 </li>
<?php } ?>

<?php if ($nav == "credits") { ?>
 <li class="active">
   <?php echo $navLoc->getText("homeCreditsLink");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../home/credits.php" class="alt1"><?php echo $navLoc->getText("homeCreditsLink");?></a>
 </li>
<?php } ?>

 <li>
   <a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>
 </li>
</ul>
