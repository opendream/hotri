<script language="JavaScript1.1" >
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
// JavaScript Document

oed = {
	<?php
	require_once(REL(__FILE__, "../classes/Localize.php"));
	$jsLoc = new Localize(OBIB_LOCALE,$tab);

	echo "successMsg : '".$jsLoc->getText('lookup_optsUpdated')."',\n";
	?>
	init: function () {
		oed.initWidgets();

		oed.url = 'lookupOptsData.php';
		oed.editForm = $('#editForm');

		$('#updtBtn').bind('click',null,oed.doUpdate);

		oed.fetchOpts();
		oed.resetForms()
	},

	//------------------------------
	initWidgets: function () {
	},
	
	resetForms: function () {
		//console.log('resetting!');
		$('#updateMsg').hide();
		$('#msgDiv').hide();
		$('#lookupVal').focus();
	},
	
	doBackToList: function () {
		oed.fetchOpts();
		$('#lookupVal').focus();
	},

	//------------------------------
	fetchOpts: function () {
	  $.getJSON(oed.url,{mode:'getOpts'}, function(data){
	  	$('#protocol').val(data.protocol);
			$('#maxHits').val(data.maxHits);
			$('#keepDashes').val([data.keepDashes]);
			$('#callNmbrType').val(data.callNmbrType);
			$('#autoDewey').val([data.autoDewey]);
			$('#defaultDewey').val(data.defaultDewey);
			$('#autoCutter').val([data.autoCutter]);
			$('#cutterType').val(data.cutterType);
			$('#cutterWord').val(data.cutterWord);
			$('#autoCollect').val([data.autoCollect]);
			$('#fictionName').val(data.fictionName);
			$('#fictionCode').val(data.fictionCode);
			$('#fictionLoC').val(data.fictionLoC);
			$('#fictionDew').val(data.fictionDew);
		});
	},

	doValidate: function () {
		//console.log('user input validation not available!!!!, see admin/settings_edit');
		return true;
	},

	doUpdate: function () {
	  if (!oed.doValidate()) return;

		$('#msgDiv').hide();
		$('#mode').val('update');
		var parms = $('#editForm').serialize();
		//console.log(parms);
		$.post(oed.url, parms, function(response) {
			if (response.substr(0,1)=='<') {
				//console.log('rcvd error msg from server :<br />'+response);
				$('#msgArea').html(response);
				$('#msgDiv').show();
			}
			else if (response.substr(0,1)=='1'){
				$('#updateMsg').html(oed.successMsg);
				$('#updateMsg').show();
			  oed.doBackToList();
			}
			else {
				$('#msgDiv').hide();
			  oed.doBackToList();
			}
		});
	}
};

$(document).ready(oed.init);
</script>
