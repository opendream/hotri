<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "materials";
  $focus_form_name = "newmaterialform";
  $focus_form_field = "description";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  require_once("../shared/header.php");

?>

<form name="newmaterialform" method="POST" action="../admin/materials_new.php">
<table class="primary">
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("admin_materials_listAddmaterialtypes"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <?php echo $loc->getText("admin_materials_listDescription"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("description",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <font class="small">*</font><?php echo $loc->getText("admin_materials_delImagefile"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("imageFile",40,128,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminSubmit"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/materials_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
    </td>
  </tr>

</table>
      </form>

<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><?php echo $loc->getText("admin_materials_listNote"); ?></font></td>
<td class="noborder"><font class="small"><?php echo $loc->getText("admin_materials_new_formNoteText"); ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
