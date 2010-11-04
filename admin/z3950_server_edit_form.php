<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "lookupHosts";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  require_once('../lookup2/LookupHostsQuery.php');
    
  $loc = new Localize(OBIB_LOCALE,$tab);
  $navbar = new Localize(OBIB_LOCALE, 'navbars');
  
  if (!is_array($postVars)) {
    $postVars = array();
  }
  if ($_POST) {
    if (0 + $_POST['id'] > 0) {
      $update = updateHost($_POST);
    }
    else {
      $update = insertHost($_POST);
    }
    
    if ($update) {
      header("Location: ./z3950_server_list.php?done=1");
    }
    else {
      $updateMsg = '<sup style="color:red">*</sup>' . $loc->getText('lookup_rqdNote');
        $postVars = $_POST;
    }
  }
  else if ($_GET['id'] > 0) {
    $host = new lookupHostQuery();
    $res = $host->execSelectOne(0 + $_GET['id']);
    $row = $host->fetchRow();
    if ($row) {
      foreach ($row as $key => $val) {
        $postVars[substr($key, 1)] = $val;
      }
    }
  }
  
  
  require_once("../shared/header.php");
?>
<h1><?php echo $navbar->getText("lookup_hosts"); ?></h1>
<h5 id="updateMsg"><font class="error"><?php echo $updateMsg; ?></font></h5>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; if (0 + $_GET['id'] > 0) { echo '?id=' . (0 + $_GET['id']); } ?>">
<table class="primary">
  <tr>
    <th align="left" colspan="2" valign="top">
      <?php if ($postVars['name']) { echo $loc->getText("lookup_hostsEditHeader"); } else { echo $loc->getText("lookup_hostsNewHeader"); } ?>
    </th>
  </tr>
  <tr>
    <td class="primary">
      <label class="reqd" for="name">
        <sup style="color: red;">*</sup>
        <?php echo $loc->getText("lookup_hostsName"); ?></td>
      </label>
    <td class="primary"><?php printMyInputText("name",32,32,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label class="reqd" for="host">
        <sup style="color: red;">*</sup>
        <?php echo $loc->getText("lookup_hostsHost"); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("host",32,32,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label class="reqd" for="db">
        <sup style="color: red;">*</sup>
        <?php echo $loc->getText("lookup_hostsDb"); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("db",16,16,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label class="reqd" for="seq">
        <sup style="color: red;">*</sup>
        <?php echo $loc->getText("lookup_hostsSeqNo"); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("seq",3,3,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label for="active">
        <?php echo $loc->getText("lookup_hostsActive"); ?>
      </label>
    </td>
    <td class="primary"><input type="checkbox" id="active" name="active" value="y"
        <?php if ($postVars["active"] == 'y') echo ' checked="checked"'; ?> ></td>
  </tr>
  <tr>
    <td class="primary">
      <label for="user">
        <?php echo $loc->getText("lookup_hostsUser"); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("user",10,10,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label for="pw">
        <?php echo $loc->getText("lookup_hostsPw"); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("pw",10,10,$postVars,$pageErrors); ?></td>
  </tr>
  <tr>
    <td class="primary">
      <label for="charset">
        <?php echo $loc->getText('Character set'); ?>
      </label>
    </td>
    <td class="primary"><?php printMyInputText("charset",10,20,$postVars,$pageErrors); ?> <font class="small"><?php echo $loc->getText('lookup_DefaultCharset'); ?></font></td>
  </tr>
  <tr>
    <td class="primary">&nbsp;</td>
    <td class="primary">
      <?php if (isset($postVars['id'])) { ?>
      <input type="hidden" id="id" name="id" value="<?php echo $postVars['id']; ?>" /> 
      <?php } ?>
      <input type="submit" value="  <?php echo $loc->getText('adminUpdate'); ?>  " class="button"> <input type="button" class="button" value="  <?php echo $loc->getText('adminCancel'); ?>  " onclick="self.location='../admin/z3950_server_list.php'">
    </td>
  </tr>
</table>
</form>
<?php include("../shared/footer.php"); ?>
