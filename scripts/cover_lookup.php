<?php
$tab = "cataloging";
$nav = "new";

require_once("../shared/common.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE,$tab);

?>
$(document).ready(function() {
  img_look = '';
  // Keep first state of cover lookup
  var initial = $('#lookup_field').html();

  coverLook = function() {
    var isbn_parsed = validateISBN($('#values020a').val());
    if (isbn_parsed != false) {
      $('#isbn-error').remove();
      
      $('#lookup_field').html('<?php echo $loc->getText('coverLookupWait'); ?>');
      $.get('../catalog/cover_lookup.php',  { isbn: isbn_parsed }, function(data) {
        if (data.substring(0,4) != 'http') {
          $('#lookup_field').html('<font class="error"><?php echo $loc->getText('coverLookupNotFound'); ?></font> <a id="lookup_back" href="#" onclick="cancelLook(); return false;"><?php echo $loc->getText('lookup_goBack'); ?></a><blockquote style="background: #ccc; margin: 5px; padding: 3px; width: 324px;">' + data + '</blockquote>');
        }
        else {
          img_look = data;
          saveLook();
        }
      });
    }
    else {
      form_row = $('#values020a').parent();
      if ($('#isbn-error').length < 1) {
        $('#values020a').parent().prepend('<div id="isbn-error"><font class="error"><?php echo $loc->getText('coverLookupISBNInvalid'); ?></font></div>');
      }
      $('#isbn-error').hide().fadeIn();
    }
  };
  cancelLook = function() {
    $('#lookup_field').html(initial);
    $('#cover_lookup').click(function() { coverLook(); });
  };
  saveLook = function(data) {
    if ($('#values020a').val() != '') {
      $('#lookup_field').html('<?php echo $loc->getText('Found'); ?>: <br><img src="' + img_look + '"><br><input type="checkbox" id="uselookup" name="uselookup" value="yes" checked="checked" onchange="cancelLook();"> <label for="uselookup"><?php echo $loc->getText('coverLookupSelect'); ?></label>');
    }
  };
  
  $('#cover_lookup').click(function() { coverLook(); });
  
  var validateISBN = function(input) {
    var val = input.replace(/[^x0-9]+/gi,'');
    len = val.length;
    var valid = true;
    if (len < 10) {
      valid = false;
    }
    else if (len > 10) {
      val = val.replace(/x/gi, '');
      if (val.length != 13) {
        valid = false;
      }
    }
    
    return valid ? val : false;
  };
});
