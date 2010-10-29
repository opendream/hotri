<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
?>
<table class="primary">
<tr>
<th><?php echo $loc->getText('Field'); ?></th>
<th><?php echo $loc->getText('Value'); ?></th>
</tr>
<tr>
<td  align="right" class="primary"><?php echo $loc->getText('Material Type'); ?></td>
<?php
  $dmQ = new DmQuery();
  $dmQ->connect();
  $dm = $dmQ->get1("material_type_dm",$materialCd);
  $material_type= $dm->getDescription();
  $dmQ->close();
?>
<td  align="Left" class="primary">
<?php
echo H($material_type);
?>
</td></tr>
<tr>
<td align="right" class="primary"><?php echo $loc->getText('Tag'); ?></td>
<td align="Left" class="primary">
<?php printInputText("tag",3,3,$postVars,$pageErrors); ?>
<input type="button" onClick="javascript:popSecondary('../catalog/usmarc_select.php?retpage=<?php echo HURL($returnPg);?>')" value="<?php echo $loc->getText('Select'); ?>" class="button">
</td></tr>
<tr>
<td  align="right" class="primary"><?php echo $loc->getText('Subfield Code'); ?></td>
<td  align="Left" class="primary">
<?php printInputText("subfieldCd",1,1,$postVars,$pageErrors); ?>
</td></tr>
<tr>
<td  align="right" class="primary"><?php echo $loc->getText('Description'); ?></td>
<td  align="Left" class="primary">
<?php printInputText("descr",32,64,$postVars,$pageErrors); ?>
</td></tr>
<tr>
<td  align="right" class="primary"><?php echo $loc->getText('Required?'); ?></td>
<td  align="Left" class="primary">
<SELECT name="required" id="required" tabindex="4">
<OPTION value="Y" <?php if ((isset($postVars["required"]))&& ($postVars["required"]=="Y")) echo "selected"; ?>><?php echo $loc->getText('TRUE'); ?></OPTION>
<OPTION value="N" <?php if ((isset($postVars["required"]))&& ($postVars["required"]=="N")) echo "selected"; ?>><?php echo $loc->getText('FALSE'); ?></OPTION>
</SELECT>
</td></tr>

<tr>
<td  align="right" class="primary"><?php echo $loc->getText('cntrltype'); ?></td>
<td  align="Left" class="primary">
<SELECT name="cntrltype" id="cntrltype" tabindex="7">
<OPTION value="0"  <?php if((isset($postVars["cntrltype"]))&&($postVars["cntrltype"]=="0")) echo "selected"; ?>><?php echo $loc->getText('Text Field'); ?></OPTION>
<OPTION value="1"  <?php if((isset($postVars["cntrltype"]))&&($postVars["cntrltype"]=="1")) echo "selected"; ?>><?php echo $loc->getText('Text Area'); ?></OPTION>
</SELECT>
</td></tr>

<tr>
<td align="center" colspan="2" class="primary">
<input type="submit" value="<?php echo $loc->getText("adminSubmit"); ?>" class="button">
<input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</td></tr>
</table>
