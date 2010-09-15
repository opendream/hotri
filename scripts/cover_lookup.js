$(document).ready(function() {
  img_look = '';
  coverLook = function() {
    var isbn_parsed = validateISBN($('#values020a').val());
    if (isbn_parsed != false) {
      $('#isbn-error').remove();
      
      $('#lookup_field').html('Now searching, please wait..');
      $.get('../catalog/cover_lookup.php',  { isbn: isbn_parsed }, function(data) {
        if (data.substring(0,4) != 'http') {
          $('#lookup_field').html('<font class="error">Book cover not found!</font> <a id="lookup_back" href="#" onclick="cancelLook(); return false;">Back</a><blockquote style="background: #ccc; margin: 5px; padding: 3px; width: 324px;">' + data + '</blockquote>');
        }
        else {
          img_look = data;
          $('#lookup_field').html('Found: <br><img src="' + data + '"><br><a href="#" onclick="saveLook();return false;">Save</a> | <a href="#lookup_anchor" onclick="cancelLook(); return false;">Cancel</a>');
        }
      });
    }
    else {
      form_row = $('#values020a').parent();
      if ($('#isbn-error').length < 1) {
        $('#values020a').parent().prepend('<div id="isbn-error"><font class="error">ISBN format not valid.</font></div>');
      }
      $('#isbn-error').hide().fadeIn();
    }
  };
  cancelLook = function() {
    $('#lookup_field').html('No bibliography picture? <input type="button" class="button" id="cover_lookup" name="cover_lookup"  value="search for this one">');
    $('#cover_lookup').click(function() { coverLook(); });
  };
  saveLook = function(data) {
    if ($('#values020a').val() != '') {
      $('#lookup_field').html('<img src="' + img_look + '"><br><input type="checkbox" name="uselookup" value="yes" checked="checked"> Use this image for bibliography picture');
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
