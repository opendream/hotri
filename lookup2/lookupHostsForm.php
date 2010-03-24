<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $nav = "lookupHosts";
  $focus_form_name = "editForm";
  $focus_form_field = "seq";

	require_once(REL(__FILE__, "../shared/common.php"));
  require_once(REL(__FILE__, "../functions/inputFuncs.php"));
  require_once(REL(__FILE__, "../shared/logincheck.php"));
  require_once(REL(__FILE__, "../shared/header.php"));
  require_once(REL(__FILE__, "../classes/Localize.php"));
  $loc = new Localize(OBIB_LOCALE,$tab);
?>

<div id="listDiv">
<form id="showForm" name="showForm">
<h5 id="updateMsg"></h5>
<h1><span id="listHdr"></span></h1>
<table id="showList" name="showList" class="primary striped">
	<thead>
  <tr>
    <th colspan="1" valign="top" nowrap="yes">
      &nbsp;
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsSeqNo"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsActive"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsHost"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsName"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsDb"); ?>
    </th>
    <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsUser"); ?>
    </th>
     <th valign="top" nowrap="yes">
      <?php echo $loc->getText("lookup_hostsPw"); ?>
    </th>
    <th valign="top" nowrap="yes">
      Charset:
    </th>
  </tr>
	</thead>
	<tbody>
	  <!--to be filled in by Javascript and Server-->
	</tbody>
	<tfoot>
  <tr>
    <td><input type="hidden" id="xxx" name="xxx" value=""></td>
  </tr>
	<tr>
	  <td colspan="9" class="primary" align="center">
				<input type="button" id="newBtn" value="Add New Host" class="button" />
		</td>
	</tr>
	</tfoot>
</table>
</form>
</div>


<div id="editDiv">
<form id="hostForm" name="editForm">
<h5 id="reqdNote" class="reqd"><sup>*</sup><?php echo $loc->getText("lookup_rqdNote"); ?></h5>
<table id='editTbl' class="primary">
	<thead>
  <tr>
    <th colspan="2" nowrap="yes" align="left"><span id="hostHdr"></span></th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td nowrap="true" class="primary">
      <label for="name" class="reqd"><sup>*</sup><?php echo $loc->getText("lookup_hostsName"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("name",32,32,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="host" class="reqd"><sup>*</sup><?php echo $loc->getText("lookup_hostsHost"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("host",32,32,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="db" class="reqd"><sup>*</sup><?php echo $loc->getText("lookup_hostsDb"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("db",16,16,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="seq" class="reqd"><sup>*</sup><?php echo $loc->getText("lookup_hostsSeqNo"); ?></label>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("seq",3,3,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="active"><?php echo $loc->getText("lookup_hostsActive"); ?></label>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" id="active" name="active" value="y"
        <?php if (isset($postVars["active"])) echo H($postVars["active"]); ?> >
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="user"><?php echo $loc->getText("lookup_hostsUser"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("user",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="pw"><?php echo $loc->getText("lookup_hostsPw"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("pw",10,10,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <label for="charset">Character Set:
    </td>
    <td valign="top" class="primary">
      <?php printMyInputText("charset",10,20,$postVars,$pageErrors); ?> <font class="small">default: leave empty</font>
    </td>
  </tr>
  <tr>
    <td><input type="hidden" id="mode" name="mode" value=""></td>
    <td><input type="hidden" id="id" name="id" value=""></td>
  </tr>
  <tfoot>
  <tr>
    <td colspan="1" class="primary" align="left">
			<input type="button" id="addBtn" value="Add" class="button" />
			<input type="button" id="updtBtn" value="Update" class="button" />
			<input type="button" id="cnclBtn" value="Cancel" class="button" />
    </td>
    <td colspan="1" class="primary" align="right">
			<input type="button" id="deltBtn" value="Delete" class="button" />
    </td>
  </tr>
  </tfoot>
  </tbody>

</table>
</form>
</div>

<div id="msgDiv"><fieldSet id="msgArea"></fieldset></div>

<?php include("../shared/footer.php"); ?>
