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
<?php if ($nav == "searchform") { ?>
 <li class="active">
   <?php echo $navLoc->getText("catalogSearch1");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../catalog/index.php" class="alt1"><?php echo $navLoc->getText("catalogSearch2");?></a>
 </li>
<?php } ?>

<?php if ($nav == "search") { ?>
 <li class="active">
   <?php echo $navLoc->getText("catalogResults");?>
 </li>
<?php } ?>

<?php if ($nav == "view") { ?>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibInfo");?>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "newcopy") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogCopyNew");?>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "editcopy") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogCopyEdit");?>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "edit") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibEdit");?>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "editmarc") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibEditMarc");?>
 </li>
 <li>
   <a href="../catalog/biblio_marc_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y')"><?php echo $navLoc->getText("catalogBibMarcNewFld");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "newmarc") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibMarcNewFldShrt");?>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "editmarcfield") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibMarcEditFld");?>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "holds") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogHolds");?>
 </li>
 <li>
   <a href="../catalog/biblio_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;title=<?php echo HURL($title);?>" class="alt1"><?php echo $navLoc->getText("catalogDelete");?></a>
 </li>
<?php } ?>

<?php if ($nav == "delete") { ?>
 <li>
   <a href="../shared/biblio_view.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibInfo");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_edit.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEdit");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogBibEditMarc");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid);?>&amp;reset=Y" class="alt1"><?php echo $navLoc->getText("catalogCopyNew");?></a>
 </li>
 <li>
   <a href="../catalog/biblio_hold_list.php?bibid=<?php echo HURL($bibid);?>" class="alt1"><?php echo $navLoc->getText("catalogHolds");?></a>
 </li>
 <li class="active">
   <?php echo $navLoc->getText("catalogDelete");?>
 </li>
<?php } ?>

<?php if ($nav == "new") { ?>
 <li class="active">
   <?php echo $navLoc->getText("catalogBibNew");?>
 </li>
<?php } else { ?>
 <li>
   <a href="../catalog/biblio_new.php" class="alt1"><?php echo $navLoc->getText("catalogBibNew");?></a>
 </li>
<?php } ?>
  
 <li>
<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>
 </li>
</ul>
