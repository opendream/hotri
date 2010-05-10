<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "cover_opts";
  $focus_form_name = "coveroptsform";
  $focus_form_field = "coverOptsKey";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  // Load cover options
  require_once('../classes/CoverOptsQuery.php');
  $opts = new CoverOptsQuery();

  if ($_POST) {
    $opts->setAWS($_POST);
?>
<font class="error">Data has been updated.</font>
<?
  }
  $form = $opts->getAWS();
  $postVars['coverOptsKey'] = $form['aws_key'];
  $postVars['coverOptsSecretKey'] = $form['aws_secret_key'];
  $postVars['coverOptsAccId'] = $form['aws_account_id'];
?>
<form name="<? echo $focus_form_name; ?>" method="POST" action="<? echo $_SERVER['SCRIPT_NAME']; ?>">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("Edit cover lookup options (Amazon AWS)"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("AWS Key"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("coverOptsKey",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("AWS Secret Key"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("coverOptsSecretKey",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("AWS Account ID"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("coverOptsAccId",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminUpdate"); ?>  " class="button">
    </td>
  </tr>
</table>
</form>
