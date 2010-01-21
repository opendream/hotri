<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "materials";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  #****************************************************************************
  #*  Checking for query string.  Go back to material type list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../admin/materials_list.php");
    exit();
  }
  $code = $_GET["code"];
  $description = $_GET["desc"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  $dmQ->delete("material_type_dm",$code);
  $dmQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<?php echo $loc->getText("admin_materials_delMaterialType"); ?>
<?php echo H($description);?><?php echo $loc->getText("admin_materials_delMaterialdeleted"); ?>
<br><br>
<a href="../admin/materials_list.php"><?php echo $loc->getText("admin_materials_Return"); ?></a>

<?php require_once("../shared/footer.php"); ?>
