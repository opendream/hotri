<script language="JavaScript1.1" >
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

// JavaScript Document
//------------------------------------------------------------------------------
// lookup Javascript
lkup = {
<?php
	require_once(REL(__FILE__, "../classes/Localize.php"));
	$jsLoc = new Localize(OBIB_LOCALE,$tab);

	echo "z3950Search				:'".$jsLoc->getText("lookup_z3950Search")."',\n";
	echo "isbn							:'".$jsLoc->getText("lookup_isbn")."',\n";
	echo "issn							:'".$jsLoc->getText("lookup_issn")."',\n";
	echo "lccn							:'".$jsLoc->getText("lookup_lccn")."',\n";
	echo "title							:'".$jsLoc->getText("lookup_title")."',\n";
	echo "author						:'".$jsLoc->getText("lookup_author")."',\n";
	echo "keyword						:'".$jsLoc->getText("lookup_keyword")."',\n";
	echo "publisher					:'".$jsLoc->getText("lookup_publisher")."',\n";
	echo "pubLoc						:'".$jsLoc->getText("lookup_pubLoc")."',\n";
	echo "pubDate						:'".$jsLoc->getText("lookup_pubDate")."',\n";
	echo "andOpt						:'".$jsLoc->getText("lookup_andOpt")."',\n";
	echo "search						:'".$jsLoc->getText("lookup_search")."',\n";
	echo "abandon						:'".$jsLoc->getText("lookup_abandon")."',\n";
	echo "repository				:'".$jsLoc->getText("lookup_repository")."',\n";
	echo "yaz_setup_failed	:'".$jsLoc->getText("lookup_yazSetupFailed")."',\n";
	echo "badQuery					:'".$jsLoc->getText("lookup_badQuery")."',\n";
	echo "patience					:'".$jsLoc->getText("lookup_patience")."',\n";
	echo "resetInstr				:'".$jsLoc->getText("lookup_resetInstr")."',\n";
	echo "goBack						:'".$jsLoc->getText("lookup_goBack")."',\n";
	echo "yazError					:'".$jsLoc->getText("lookup_yazError")."',\n";
	echo "nothingFound			:'".$jsLoc->getText("lookup_nothingFound")."',\n";
	echo "tooManyHits				:'".$jsLoc->getText("lookup_tooManyHits")."',\n";
	echo "refineSearch			:'".$jsLoc->getText("lookup_refineSearch")."',\n";
	echo "success						:'".$jsLoc->getText("lookup_success")."',\n";
	echo "hits							:'".$jsLoc->getText("lookup_hits")."',\n";
	echo "callNmbrType			:'".$jsLoc->getText("lookup_callNmbrType")."',\n";
	echo "useThis						:'".$jsLoc->getText("lookup_useThis")."',\n";
	echo "searchError				:'".$jsLoc->getText("lookup_searchError")."',\n";
?>
	init: function () {
		// get header stuff going first
		lkup.initWidgets();

		lkup.url = 'lookupSrvr.php';
		lkup.form = $('#lookupForm');
		
		// button on search screen gets special treatment
		lkup.srchBtn = $('#srchBtn');
		lkup.resetForm();
		//lkup.disableSrchBtn();
		lkup.srchBtn.bind('click',null,lkup.doSearch);

    $('.criteria').bind('change',null,lkup.enableSrchBtn);
		$('#quitBtn').bind('click',null,lkup.doAbandon);
		$('#retryBtn').bind('click',null,lkup.doBackToSrch);
		$('#choiceBtn1').bind('click',null,lkup.doBackToSrch);
		$('#choiceBtn2').bind('click',null,lkup.doBackToSrch);
		
		// modify original biblioFields form to better suit our needs
		$('#selectionDiv input[value="Cancel"]').removeAttr('onClick');
		$('#selectionDiv input[value="Cancel"]').attr('id','biblioBtn');
		$('#selectionDiv input[value="Cancel"]').attr('value','Go Back');

		// FIXME - fl only '*' should be colored
		$('#selectionDiv font').css('color','red');
		
		$('#selectionDiv sup').css('color','red');
		lkup.inputColor = $('input[name=callNmbr1]').css('color');
		$('#selectionDiv input[name=values[100a]]').bind('change',null,lkup.fixAuthor);
		$('#selectionDiv input[name=values[245a]]').bind('change',null,lkup.fixTitle);

    // find title line of edit form and add another 'cancel' button
    $('#selectionDiv form tbody th').attr('colspan','1');
		var newBtn = '<input id="newGoBkBtn" type="button" class="button" value="'+lkup.goBack+'" />'
		$('<td id="biblioBtn2" class="primary" align="center")>'+newBtn+'</td>')
			.appendTo($('#selectionDiv form tbody tr:first-child'));

		lkup.fetchHosts();  //on completion, search form will appear
		lkup.fetchOpts();  //for debug use
	},
	
	//------------------------------
	initWidgets: function () {
	},
	
	resetForm: function () {
		//console.log('resetting Search Form');
		//$('#help').hide();
		$('#searchDiv').show();
		$('#waitDiv').hide();
		$('#retryDiv').hide();
		$('#choiceDiv').hide();
		$('#selectionDiv').hide();

		//lkup.form[0].reset();
		$('#lookupVal').focus();
		lkup.disableSrchBtn();
	},
	
	disableSrchBtn: function () {
//	  lkup.srchBtnBgClr = lkup.srchBtn.css('color');
//	  lkup.srchBtn.css('color', '#888888');
		lkup.srchBtn.disable();
	},
	enableSrchBtn: function () {
//	  lkup.srchBtn.css('color', lkup.srchBtnBgClr);
		lkup.srchBtn.enable();
	},

	doBackToSrch: function () {
		lkup.resetForm();
		lkup.enableSrchBtn();
	},

	doBackToChoice: function () {
		$('#selectionDiv').hide();
		$('#choiceDiv').show();
	},
	//------------------------------
	fetchOpts: function () {
	  $.getJSON(lkup.url,{mode:'getOpts'}, function(data){
			lkup.opts = data;
		});
	},

	fetchHosts: function () {
	  $.getJSON(lkup.url,{mode:'getHosts'}, function(data){
			lkup.hostJSON = data;
			$('#waitDiv').hide();
			$('#searchDiv').show();
		});
	},

	doAbandon: function () {
	  $.getJSON(lkup.url,{mode:'abandon'}, function(data){
			$('#searchDiv').show();
		});
	},

	//------------------------------
	doSearch: function () {
	  // advise user that this takes time to complete
	  var srchBy = flos.getSelectBox($('#srchBy'),'getText');
	  var srchBy2 = flos.getSelectBox($('#srchBy2'),'getText');
	  //var srchBy = $('#srchBy').text();
	  //var srchBy2 = $('#srchBy2').text();
	  var theTxt = '<h5>';
		theTxt += "Looking for "+srchBy+" '" + $('#lookupVal').val() + "'<br />";
	  if ($('#lookupVal2').val() != '')
			theTxt += "&nbsp;&nbsp;&nbsp;with "+srchBy2+" '"+$('#lookupVal2').val()+"'<br />";
		theTxt += 'using the '+lkup.opts.protocol+' protocol at :<br />';
		var n=1;
		for (nHost in lkup.hostJSON) {
			theTxt += '&nbsp;&nbsp;&nbsp;'+n+'. '+lkup.hostJSON[nHost].name+'<br />';
			n++;
		}
		theTxt += '</h5>';
	  $('#waitText').html(theTxt);
	  
		$('#searchDiv').hide('slow');
		$('#waitDiv').show('slow');
		
		// note for this to work, all form fields MUST have a 'name' attribute
		$('lookupForm #mode').val('search');
		var srchParms = $('#lookupForm').serialize();
		//console.log(srchParms);
		$.post(lkup.url, srchParms, function(response) {
			$('#waitDiv').hide(1000);
			
			if ($.trim(response).substr(0,1) != '{') {
				$('#retryHead').empty();
				$('#retryHead').html(lkup.searchError);
				$('#retryMsg').empty();
				$('#retryMsg').html(response);
				$('#retryDiv').show(1000);
			}
			else {
			
				var rslts = eval('('+response+')'); // JSON 'interpreter'
				//console.log('ttl hits = '+rslts.ttlHits);
				if (rslts.ttlHits == 'none') {
					//console.log(rslts.msg);
		  		//{'ttlHits':'none','maxHits':'$postVars[maxHits]',
					// 'msg':$lookLoc->getText('lookup_noResponse'),
					// 'msg2':$lookLoc->getText('lookup_checkHostSpecifications')}
					var str = rslts.msg+':<br />&nbsp;&nbsp;&nbsp;'+rslts.srch1.byName+' = '+rslts.srch1.lookupVal;
					$('#retryHead').empty();
					$('#retryHead').html(rslts.msg);
					$('#retryMsg').empty();
					$('#retryMsg').html(rslts.msg2);
					$('#retryDiv').show(1000);
				}

				if (rslts.ttlHits < 1) {
					//console.log('nothing found');
				  //{'ttlHits':$ttlHits,'maxHits':$postVars[maxHits],
					// 'msg':".$lookLoc->getText('lookup_NothingFound'),
					// 'srch1':['byName':$srchByName,'val':$lookupVal],
					// 'srch2':['byName':$srchByName2,'val':$lookupVal2]}
					var str = '&nbsp;&nbsp;&nbsp;'+rslts.srch1.byName+' = '+rslts.srch1.lookupVal;
					if (rslts.srch2.lookupVal != '')
						str += '<br />&nbsp;&nbsp;&nbsp;'+rslts.srch2.byName+' = '+rslts.srch2.lookupVal;
					$('#retryHead').empty();
//					$('#retryHead').html(lkup.nothingFound);
					$('#retryHead').html(rslts.msg);
					$('#retryMsg').empty();
					$('#retryMsg').html(str);
					$('#retryDiv').show(1000);
				}

				else if (rslts.ttlHits >= rslts.maxHits) {
					//console.log('too many hits');
		  		//{'ttlHits':'$ttlHits','maxHits':'$postVars[maxHits]',
					// 'msg':'$msg1', 'msg2':'$msg2'}
					var str = rslts.msg+' ('+rslts.ttlHits+' ).<br />'+rslts.msg2;
					$('#retryHead').empty();
					$('#retryHead').html(lkup.tooMany);
					$('#retryMsg').empty();
					$('#retryMsg').html(str);
					$('#retryDiv').show(1000);
				}
			
				else if (rslts.ttlHits > 1){
					//console.log('more than one hit');
					$('#choiceSpace').empty();
					$('#choiceSpace').append('<h3>Success!  <span id="ttlHits"></span></h3>');

					var nHits = 0;
					lkup.hostData = rslts.data;
					$.each(rslts.data, function(hostIndex,hostData) {
					  $('#choiceSpace').append('<hr width="50%">');
					  if (typeof(hostData) != undefined) {
					  $('#choiceSpace').append('<h4>Repository: '+lkup.hostJSON[hostIndex].name+'</h4>');
					  $.each(hostData, function(hitIndex,hitData) {
					    nHits++;
					    var html = '<form class="hitForm"><table border="0">';
					    html += '<tr><td class="primary">LCCN</th><td class="primary">'+hitData['010a']+'</td></tr>';
					    html += '<tr><td class="primary">ISBN</th><td class="primary">'+hitData['020a']+'</td></tr>';
					    html += '<tr><td class="primary">Title</th><td class="primary">'+hitData['245a']+'</td></tr>';
					    html += '<tr><td class="primary">Author</th><td class="primary">'+hitData['100a']+'</td></tr>';
					    html += '<tr><td class="primary">Publisher</th><td class="primary">'+hitData['260b']+'</td></tr>';
					    html += '<tr><td class="primary">Location</th><td class="primary">'+hitData['260a']+'</td></tr>';
					    html += '<tr><td class="primary">Date</th><td class="primary">'+hitData['260c']+'</td>';
							var id = 'host'+hostIndex+'-hit'+hitIndex;
					    html += '<td id="'+id+'" class="primary"><input type="button" value="This One" class="button" /></td></tr>';
							html += '</table></form>';
							$('#choiceSpace').append(html);
							$('#'+id).bind('click',{host:hostIndex,hit:hitIndex,data:hitData},lkup.doSelectOne);
						}); // $.each(hostData...
						} // if (lkup.hostJason[hostIndex])
					}); // $.each(rslts.data...
					$('#ttlHits').html(nHits+' hits found.')
					console.log('all choices drawn')
					//$('#choiceSpace').append(response);
					$('#biblioBtn').bind('click',null,lkup.doBackToChoice);
					$('#biblioBtn2').bind('click',null,lkup.doBackToChoice);
					$('#choiceDiv').show('slow');
				} // else if (rslts.ttlHits > 1)
				else if (rslts.ttlHits == 1){
				  var data;
					//console.log('single hit found');
					lkup.hostData = rslts.data;
					$.each(rslts.data, function(hostIndex,hostData) {
					  $.each(hostData, function(hitIndex,hitData) {
					  	data = hitData;
					  });
					});
					$('#biblioBtn').bind('click',null,lkup.doBackToSrch);
					$('#biblioBtn2').bind('click',null,lkup.doBackToSrch);
					lkup.doShowOne(data);
				}
			} // else
		}); // .post
	},
	
	doSelectOne: function (e) {
	  var host = e.data.host;
	  var hit = e.data.hit;
	  var data = e.data.data;
		//console.log('hit #'+hit+' of host #'+host);
		lkup.doShowOne(data);
	},
	doShowOne: function (data){
		// setting defaults
  	$('input[name=callNmbr1]').val('call nmbr required');
  	$('input[name=callNmbr1]').css('color','red');
  	$('input[name=values[245a]').val('title required');
  	$('input[name=values[245a]').css('color','red');
  	$('input[name=values[100a]]').val('author required');
  	$('input[name=values[100a]]').css('color','red');
		$('input[name=opacFlg]').val(['CHECKED']);

		var tag;
		for (tag in data) {
			//console.log('tag='+tag);
			if (data[tag] != '') {
				$('input[name=values['+tag+']]').val(data[tag]);
				$('input[name=values['+tag+']]').css('color',lkup.inputColor);
			}
		}
		
		lkup.setCallNmbr(data);
		lkup.setCollection(data);
		
		$('#choiceDiv').hide();
		$('#selectionDiv').show();
	},
	setCallNmbr: function (data) {
		switch (lkup.opts['callNmbrType'].toLowerCase())  {
		case 'loc':
    	$('input[name=callNmbr1]').val(data['050a']);
    	$('input[name=callNmbr2]').val(data['050b']);
			break;
		case 'dew':
		  var callNmbr = lkup.makeCallNmbr(data['082a']);
    	$('input[name=callNmbr1]').val(callNmbr);
    	var cutter = lkup.makeCutter(data['100a'], data['245a']);
    	$('input[name=callNmbr2]').val(cutter); // just for show, posting done in called routine
			break;
		case 'udc':
		  var callNmbr = lkup.makeCallNmbr(data['080a']);
    	$('input[name=callNmbr1]').val(callNmbr);
    	$('input[name=callNmbr2]').val(data['080b']);
			break;
		case 'local':
			// leave the fields blank for user entry
			break;
		default:
		  break;
		}
		if ($('input[name=callNmbr1]').val() != '') {
    	$('input[name=callNmbr1]').css('color',lkup.inputColor);
		}
	},

	makeCallNmbr: function (code) {
		if ((code) && ((lkup.opts['callNmbrType']).toLowerCase() == "dew")) {
			var fictionDew = lkup.opts['fictionDew'].split(' ');
			if (lkup.opts['autoDewey']
					&&
					((code == "") || (code == "[Fic]"))
					&&
					(fictionDew.indexOf(code) >= 0)
				 ) {
				//echo "using default dewey code" . '</br />';
				dew = lkup.opts['defaultDewey'];
			}

			var parts = code.split('.');
			var base1 = parts[0];
			var callNmbr = base1;
			if (parts[1]) {
				var base2 = parts[1].split('/');
				callNmbr += '.'+base2;
			}
			callNmbr = callNmbr.replace('/', '');

			return callNmbr;
		}
	},
	
	fixTitle: function () {
	  var titl = $('input[name=values[245a]]').val();
		if (titl != '') {
    	$('input[name=values[245a]]').css('color',lkup.inputColor);
    	var auth = $('input[name=values[100a]]').val();
	  	lkup.makeCutter(auth, titl); // will post direct to screen
		}
		else {
    	$('input[name=values[245a]]').css('color','red');
		}
	},
	
	fixAuthor: function () {
	  var auth = $('input[name=values[100a]]').val();
		if (auth != '') {
    	$('input[name=values[100a]]').css('color',lkup.inputColor);
    	var titl = $('input[name=values[245a]]').val();
	  	lkup.makeCutter(auth, titl);
		}
		else {
    	$('input[name=values[100a]]').css('color','red');
		}
	},

	makeCutter: function (auth,titl) {
		if ((auth != 'undefined') && (lkup.opts['autoCutter'])) {
	  	$.getJSON(lkup.url,{mode:'getCutter', author:auth}, function(data){
				var cutter = data['cutter'];
	  		if (lkup.opts['cutterType'] == 'Dew') {
			  	// suffix is first char of a specified word in title
					cutter += lkup.makeSuffix($('input[name=values[245a]]').val());
				}
				else if (lkup.opts['cutterType'] == 'LoC') {
					// add copyright year as suffix
					cutter += ' '+($('input[name=values[260c]]').val()).substr(1,4);
				}
				$('input[name=callNmbr2]').val(cutter);
			});
		}
	},

	makeSuffix: function (s) {
		inputWords = s.split('/');

		var nWords = 0;
		var goodWords = '';
		for (var index in inputWords) {
			if ((inputWords[index] != ' ') && ((lkup.opts['noiseWords']).indexOf(inputWords[index]) < 0)) {
				goodWords+=' '+inputWords[index];
				nWords++;
			}
		}
		goodWords = $.trim(goodWords);
		wordArray = goodWords.split(/\s+/);

		if (nWords == 1)
			var sufx = (wordArray[0]).substr(0,1);
		else if (nWords <= lkup.opts['cutterWord'])
			sufx = (wordArray[nWords-1]).substr(0,1);
		else if (nWords > lkup.opts['cutterWord'])
			sufx = (wordArray[lkup.opts['cutterWord']-1]).substr(0,1);

		return sufx.toLowerCase();
	},

	setCollection: function (data) {
		//// -- attempt to determine proper collection from LOC call number
		//				this is experimental and may not be to your taste
		if (lkup.opts['autoCollect']) {
			var index = lkup.opts['fictionCode'];
			var collection = lkup.opts['defaultCollect'];

			if ((data['050a']) && (lkup.opts['callNmbrType'] == 'LoC')) {
				var locClass = (data['050a']).substr(0,2);
				if ((lkup.opts['fictionLoC']).indexOf(locClass) >= 0) {
					collection = $.trim(lkup.opts['fictionName']);
				}
			}
			else if ((data['082a']) && (lkup.opts['callNmbrType'] == 'Dew')) {
				var dewClass = (data['082a']).substr(0,3);
				if ((lkup.opts['fictionDew']).indexOf(dewClass) >= 0) {
					collection = $.trim(lkup.opts['fictionName']);
				}
			}
			$('#collectionCd').val(collection);
		}
	}
};

$(document).ready(lkup.init);
</script>
