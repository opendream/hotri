<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");

?>
<input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton"><br />
<br />

<ul>
<?php if ($nav == "summary") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminSummary");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/index.php" class="alt1"><?php echo $navLoc->getText("adminSummary");?></a>
 </li>
<?php } ?>

<?php if ($nav == "staff") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminStaff");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/staff_list.php" class="alt1"><?php echo $navLoc->getText("adminStaff");?></a>
 </li>
<?php } ?>

<?php if ($nav == "settings") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminSettings");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/settings_edit_form.php?reset=Y" class="alt1"><?php echo $navLoc->getText("adminSettings");?></a>
 </li>
<?php } ?>

<?php if ($nav == "classifications") { ?>
 <li class="active">
   <?php echo $navLoc->getText("Member Types");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/mbr_classify_list.php" class="alt1"><?php echo $navLoc->getText("Member Types");?></a>
 </li>
<?php } ?>

<?php if ($nav == "member_fields") { ?>
 <li class="active">
   <?php echo $navLoc->getText("Member Fields");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/member_fields_list.php" class="alt1"><?php echo $navLoc->getText("Member Fields");?></a>
 </li>
<?php } ?>

<?php if ($nav == "materials") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminMaterialTypes");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/materials_list.php" class="alt1"><?php echo $navLoc->getText("adminMaterialTypes");?></a>
 </li>
<?php } ?>

<?php if ($nav == "collections") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminCollections");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/collections_list.php" class="alt1"><?php echo $navLoc->getText("adminCollections");?></a>
 </li>
<?php } ?>

<?php if ($nav == "checkout_privs") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminCheckoutPriv");?>
 </li>
<?php } else { ?>
 <li> 
   <a href="../admin/checkout_privs_list.php" class="alt1"><?php echo $navLoc->getText("adminCheckoutPriv");?></a>
 </li>
<?php } ?>
<?php if ($nav == 'cover_opts') { ?>
 <li class="active">
   <?php echo $navLoc->getText("Cover Lookup Options");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/cover_opts.php" class="alt1"><?php echo $navLoc->getText("Cover Lookup Options");?></a>
 </li>
<?php } ?>
<?php if ($nav == "z3950_opts") { ?>
 <li class="active">
   <?php echo $navLoc->getText("lookup_opts");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/z3950_opts.php" class="alt1"><?php echo $navLoc->getText("lookup_opts");?></a>
 </li>
<?php } ?>
<?php if ($nav == "lookupHosts") { ?>
 <li class="active">
   <?php echo $navLoc->getText("lookup_hosts");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/z3950_server_list.php" class="alt1"><?php echo $navLoc->getText("lookup_hosts");?></a>
 </li>
<?php } ?>
<?php if ($nav == "BulkLookup") { ?>
 <li class="active">
   <?php echo $navLoc->getText("lookup_bulk");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/BulkLookup.php?reset=Y" class="alt1"><?php echo $navLoc->getText("lookup_bulk");?></a>
 </li>
<?php } ?>
<?php if ($nav == "themes") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminThemes");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/theme_list.php" class="alt1"><?php echo $navLoc->getText("adminThemes");?></a>
 </li>
<?php } ?>

<?php if ($nav == "import_export") { ?>
 <li class="active">
   <?php echo $navLoc->getText("adminImportExport");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../admin/import_export.php" class="alt1"><?php echo $navLoc->getText("adminImportExport");?></a>
 </li>
<?php } ?>

<!--
< ?php if ($nav == "translation") { ?>
 &raquo; < ?php echo $navLoc->getText("adminTranslation");?><br>
< ?php } else { ?>
 <a href="../admin/translation_list.php" class="alt1">< ?php echo $navLoc->getText("adminTranslation");?></a><br>
< ?php } ?>
-->

 <li>
   <a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>
 </li>
</ul>
