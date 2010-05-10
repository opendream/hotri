<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "lookupOpts";
  $focus_form_name = "editForm";
  $focus_form_field = "protocol";

  require_once(REL(__FILE__, "../functions/inputFuncs.php"));
  require_once(REL(__FILE__, "../shared/logincheck.php"));
  require_once(REL(__FILE__, "../shared/header.php"));
  require_once(REL(__FILE__, "../classes/Localize.php"));
  $loc = new Localize(OBIB_LOCALE,$tab);
?>

<form id="editForm" name="editForm" method="POST" >
<h5 id="updateMsg"></h5>
<table class="primary">
	<tbody>
  <tr>
    <th colspan="2" nowrap="yes" align="left">
      <?php echo $loc->getText("lookup_optsSettings"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="protocol"><?php echo $loc->getText("lookup_optsProtocol"); ?></label>
    </td>
    <td valign="top" class="primary">
      <select id="protocol" name="protocol">
        <option value="   ">   </option>
        <option value="YAZ">YAZ</option>
        <option value="SRU">SRU</option>
      </select>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="maxHits"><?php echo $loc->getText("lookup_optsMaxHits"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("maxHits",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="keepDashes"><?php echo $loc->getText("lookup_optsKeepDashes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" id="keepDashes" name="keepDashes" value="y"
        <?php //if (isset($postVars["keepDashes"])) echo H($postVars["keepDashes"]); ?> >
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="callNmbrType"><?php echo $loc->getText("lookup_optsCallNmbrType"); ?></label>
    </td>
    <td valign="top" class="primary">
      <select id="callNmbrType" name="callNmbrType">
        <option value="   "  >     </option>
        <option value="LoC"  >LoC  </option>
        <option value="Dew"  >Dew  </option>
        <option value="UDC"  >UDC  </option>
        <option value="local">local</option>
      </select>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="autoDewey"><?php echo $loc->getText("lookup_optsAutoDewey"); ?></label>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" id="autoDewey" name="autoDewey" value="y"
        <?php //if (isset($postVars["autoDewey"])) echo H($postVars["autoDewey"]); ?> >
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="defaultDewey"><?php echo $loc->getText("lookup_optsDefaultDewey"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("defaultDewey",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="autoCutter"><?php echo $loc->getText("lookup_optsAutoCutter"); ?></label>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" id="autoCutter" name="autoCutter" value="y"
        <?php //if (isset($postVars["autoCutter"])) echo H($postVars["autoCutter"]); ?> >
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
     <label for="cutterType"><?php echo $loc->getText("lookup_optsCutterType"); ?></label>
    </td>
    <td valign="top" class="primary">
      <select id="cutterType" name="cutterType">
        <option value="   ">   </option>
        <option value="LoC">LoC</option>
        <option value="CS3">CS3</option>
      </select>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="cutterWord"><?php echo $loc->getText("lookup_optsCutterWord"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("cutterWord",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="autoCollect"><?php echo $loc->getText("lookup_optsAutoCollection"); ?></label>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" id="autoCollect" name="autoCollect" value="y"
        <?php //if (isset($postVars["autoCollect"])) echo H($postVars["autoCollect"]); ?> >
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="fictionName"><?php echo $loc->getText("lookup_optsFictionName"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fictionName",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fictionCode"><?php echo $loc->getText("lookup_optsFictionCode"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fictionCode",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fictionLoC"><?php echo $loc->getText("lookup_optsLocFictionCodes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fictionLoC",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <label for="fictionDew"><?php echo $loc->getText("lookup_optsDewFictionCodes"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("fictionDew",30,50,$postVars,$pageErrors); ?>
    </td>
  </tr>
  </tbody>
  <tfoot>
  <tr>
    <td><input type="hidden" id="mode" name="mode" value=""></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="button" id="updtBtn" name="updtBtn" class="button"
			 value="<?php echo $loc->getText("lookup_optsUpdtBtn"); ?>" />
    </td>
  </tr>
	</tfoot>
</table>
</form>
<div id="msgDiv"><fieldSet id="msgArea"></fieldset></div>
<?php include("../shared/footer.php"); ?>
