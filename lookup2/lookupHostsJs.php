<script language="JavaScript1.1" >
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

// JavaScript Document
hed = {
	<?php
	require_once(REL(__FILE__, "../classes/Localize.php"));
	$jsLoc = new Localize(OBIB_LOCALE,$tab);

	echo "listHdr : '".$jsLoc->getText('lookup_hostsListHeader')."',\n";
	echo "editHdr : '".$jsLoc->getText('lookup_hostsEditHeader')."',\n";
	echo "newHdr  : '".$jsLoc->getText('lookup_hostsNewHeader')."',\n";
	echo "successMsg : '".$jsLoc->getText('lookup_optsUpdated')."',\n";
	echo "delConfirmMsg  : '".$jsLoc->getText('lookup_hostsConfirmDelete')."',\n";
	?>
	
	init: function () {
		hed.initWidgets();

		hed.url = 'lookupHostsData.php';
		hed.editForm = $('#editForm');

		$('#reqdNote').css('color','red');
		$('.reqd sup').css('color','red');
		$('#updateMsg').hide();

		$('#showForm tFoot #newBtn').bind('click',null,hed.doNewHost);
		$('#hostForm tFoot #addBtn').bind('click',null,hed.doAddHost);
		$('#hostForm tFoot #updtBtn').bind('click',null,hed.doUpdateHost);
		$('#hostForm tFoot #cnclBtn').bind('click',null,hed.resetForms);
		$('#hostForm tFoot #deltBtn').bind('click',null,hed.doDeleteHost);

		hed.fetchHosts();
		hed.resetForms()
	},
	
	//------------------------------
	initWidgets: function () {
	},
	resetForms: function () {
		//console.log('resetting!');

	  $('#listHdr').html(hed.listHdr);
	  $('#hostHdr').html(hed.editHdr);
		$('#editDiv').hide();
	  $('#msgDiv').hide();
		$('#listDiv').show();
    $('#hostForm tFoot #cnclBtn').val('Cancel');
    
		$('#lookupVal').focus();
	},
	doBackToList: function () {
		hed.fetchHosts();
		hed.resetForms();
	},
	
	//------------------------------
	fetchHosts: function () {
	  $.getJSON(hed.url,{mode:'getHosts'}, function(data){
	    hed.hostJSON = data;
			var html = '';
			for (nHost in hed.hostJSON) {
				//console.log(data[nHost]);
	    	html += '<tr>\n';
    		html += '<td valign="top" class="primary">\n';
				html += '<input type="button" value="edit" align="center" class="button editBtn" />\n';
				html += '<input type="hidden" value="'+hed.hostJSON[nHost]['id']+'" />\n';
				html += '</td>\n';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['seq']+'</td>\n';
    		var str = ((hed.hostJSON[nHost]['active']=='y')?'yes':'no');
    		html += '<td valign="top" class="primary">'+str+'</td>\n';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['host']+'</td>\n';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['name']+'</td>\n';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['db']+'</td>\n';
    		if (hed.hostJSON[nHost]['user'] == null) hed.hostJSON[nHost]['user'] = '';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['user']+'</td>\n';
    		if (hed.hostJSON[nHost]['pw'] == null) hed.hostJSON[nHost]['pw'] = '';
    		html += '<td valign="top" class="primary">'+hed.hostJSON[nHost]['pw']+'</td>\n';
				html += '</tr>\n';
			}
			$('#showList tBody').html(html);
			$('table.striped tbody tr:odd td').addClass('alt1');
			$('table.striped tbody tr:even td').addClass('primary');
			$('.editBtn').bind('click',null,hed.doEdit);
		});
	},
	
	doNewHost: function (e) {
	  $('#hostHdr').html(hed.newHdr);
	  $('#hostForm tfoot #updtBtn').hide();
	  $('#hostForm tfoot #addBtn').show();
	  $('#hostForm tbody #name').focus();
	  
		$('#listDiv').hide();
		$('#editDiv').show();
	},
	doEdit: function (e) {
	  var theHostId = $(this).next().val();
		//console.log('you wish to edit host #'+theHostId);
		for (nHost in hed.hostJSON) {
		  if (hed.hostJSON[nHost]['id'] == theHostId) {
				hed.showHost(hed.hostJSON[nHost]);
			}
		}
	},
	
	doValidate: function () {
		//console.log('user input validation not available!!!!, see admin/settings_edit');
		return true;
	},
	
	doAddHost: function () {
	  if (!hed.doValidate()) return;

		$('#mode').val('addNew');
		var parms = $('#hostForm').serialize();
		//console.log(parms);
		$.post(hed.url, parms, function(response) {
			if (response.substr(0,1)=='<') {
				//console.log('rcvd error msg from server :<br />'+response);
				$('#msgArea').html(response);
				$('#msgDiv').show();
			}
			else {
			  hed.doBackToList();
			}
		});
	},

	doUpdateHost: function () {
	  if (!hed.doValidate()) return;

		$('#updateMsg').hide();
		$('#msgDiv').hide();
		$('#mode').val('update');
		var parms = $('#hostForm').serialize();
		//console.log(parms);
		$.post(hed.url, parms, function(response) {
			if (response.substr(0,1)=='<') {
				//console.log('rcvd error msg from server :<br />'+response);
				$('#msgArea').html(response);
				$('#msgDiv').show();
			}
			else {
				if (response.substr(0,1)=='1'){
					$('#updateMsg').html(hed.successMsg);
					$('#updateMsg').show();
				}
			  hed.doBackToList();
			}
		});
	},
	
	doDeleteHost: function (e) {
		var msg = hed.delConfirmMsg+'\n>>> '+$('#hostForm tbody #name').val()+' <<<';
	  if (confirm(msg)) {
	  	$.get(hed.url,
								{	mode:'d-3-L-3-t',
									id:$('#hostForm tbody #id').val()
								},
								function(response){
				if (($.trim(response)).substr(0,1)=='<') {
					//console.log('rcvd error msg from server :<br />'+response);
					$('#msgArea').html(response);
					$('#msgDiv').show();
				}
				else {
			  	hed.doBackToList();
				}
			});
		}
	},

	showHost: function (host) {
		//console.log('showing : '+host['name']);
	  $('#hostHdr').html(hed.editHdr);
	  $('#hostForm tfoot #addBtn').hide();
	  $('#hostForm tfoot #updtBtn').show();
	  $('#hostForm tbody #name').focus();

		$('#editTbl td #id').val(host['id']);
		$('#editTbl td #host').val(host['host']);
		$('#editTbl td #name').val(host['name']);
		$('#editTbl td #db').val(host['db']);
		$('#editTbl td #seq').val(host['seq']);
//		if (host['active'] == '1') {
//			$('#editTbl td #active').attr('checked','checked');
//		}
    $('#editTbl td #active').val([host['active']]);
		$('#editTbl td #user').val(host['user']);
		$('#editTbl td #pw').val(host['pw']);

		$('#listDiv').hide();
		$('#editDiv').show();
	}
};

$(document).ready(hed.init);
</script>
