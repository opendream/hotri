<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "lookupHosts";
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");
  require_once('../lookup2/LookupHostsQuery.php');
  
  if (0 + $_POST['id'] > 0) {
    $host = new lookupHostQuery();
    $res = $host->execSelectOne(0 + $_POST['id']);
    $row = $host->fetchRow();
    if ($row) {
      
      $update = deleteHost($_POST);
      if ($update) {
        echo $loc->getText("Z39.50 server, %name%, has been deleted.", array('name'=>$row->_name)) . '<br><br>
  <a href="../admin/z3950_server_list.php">' . $loc->getText("return to z39.50 server list") . '</a>';
      }
    }
  }
  else if (0 + $_GET['id'] > 0) {
    $host = new lookupHostQuery();
    $res = $host->execSelectOne(0 + $_GET['id']);
    $row = $host->fetchRow();
    if ($row) {
      foreach ($row as $key => $val) {
        $postVars[substr($key, 1)] = $val;
      }
?>

<center>
<form name="delstaffform" method="POST" action="../admin/z3950_server_del.php?id=<?php echo $postVars['id']; ?>">
<?php echo $loc->getText("Are you sure you want to delete server '%name%'?", array('name'=>$postVars['name'])); ?><br><br>
      <input type="hidden" name="id" value="<?php echo $postVars['id']; ?>">
      <input type="submit" value="  <?php echo $loc->getText("adminDelete"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/z3950_server_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</form>
</center>
<?php
    }
  } 
  include("../shared/footer.php"); ?>
