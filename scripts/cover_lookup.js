$(document).ready(function() {
  img_look = '';
  coverLook = function() {
    if ($('#values020a').val() != '') {
      $('#lookup_field').html('looking up..');
      $.get('../catalog/cover_lookup.php',  { isbn: $('#values020a').val() }, function(data) {
        if (data == '') {
          alert('Cover lookup not found!');
          cancelLook();
        }
        else {
          img_look = data;
          $('#lookup_field').html('Found: <br><img src="' + data + '"><br><a href="#" onclick="saveLook();return false;">Save</a> | <a href="#lookup_anchor" onclick="cancelLook(); return false;">Cancel</a>');
        }
      });
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
});
