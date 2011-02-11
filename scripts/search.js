var row_count = 1;
$(document).ready(function() {
    var loc = new Locale();

    /**
     * Functions ---------------------------------------------------------------
     */

    form_biblio_search_keyword_types = function() {
        return '<select name="keyword_type_' + row_count + '">' + 
               '  <option value="title" selected>' + loc.Title + '</option>' +
               '  <option value="author">' + loc.Author + '</option>' +
               '  <option value="subject">' + loc.Subject + '</option>' +
               '  <option value="isbn">' + loc.ISBN + '</option>' +
               '  <option value="call_nmbr">' + loc.CallNumber + '</option>' +
               '</select>';
    }

    form_biblio_search_keyword_text = function() {
        return '<input type="text" name="keyword_text_' + row_count + '" size="40" />';
    }

    form_biblio_search_expressions = function() {
        return '<select name="expression_' + row_count + '">' +
               '  <option value="and">' + loc.And + '</option>' +
               '  <option value="or">' + loc.Or + '</option>' +
               '  <option value="not">' + loc.Not + '</option>' +
               '</select>';
    }
        
    form_biblio_search_add_field = function() {
        return '<a href="javascript:add_field();" title="' + loc.AddAnotherField + '" class="add_field">[+]</a>';
    }

    add_field = function() {
        var elm_table = $("table.table_advanced_search_1");
        var elm_tr = '<tr>' +
                     '  <td>' + 
                     '    <span>' + form_biblio_search_expressions() + '</span>' +
                     '    <span>' + form_biblio_search_keyword_types() + '</span>' +
                     '    <span>' + form_biblio_search_keyword_text() + '</span>' +
                     '    <span>' + form_biblio_search_add_field() + '</span>' +
                     '  </td>' +
                     '</tr>';
        elm_table.append(elm_tr);
        row_count++;
    }

    change_legend_icon = function() {
        if ($("fieldset#advanced-search").hasClass("collapsed")) {
            $("span#legend-toggle").html("[+]");
        } else {
            $("span#legend-toggle").html("[-]");
        }
    }

    /**
     * Events ------------------------------------------------------------------
     */

    $("a.add_field").live("click", function(e) {
        e.preventDefault();
        add_field();
        $(this).hide();
    });

    $("input#btn-reset").click(function(e) {
        e.preventDefault();
        var url = window.location.href;
        if (url.match(/opac/)) {
            window.location = "../opac/index.php";
        } else if (url.match(/catalog/)) {
            window.location = "../catalog/index.php";
        }
    });

    // This event is called in the 'circ/mbr_fields.php'
    $("input#chk_auto_barcode").change(function(e) {
        _this = this;
        if ($(this).is(":checked")) {
            $.get("../circ/mbr_get_barcode.php", {}, function(data) {
                if (data != "") {
                    $("#barcodeNmbr").val(data);
                    $("#lastName").focus();
                } else {
                    var loc = new Locale();
                    alert(loc.ErrorGetAutoBarcode);
                    $(_this).removeAttr("checked");
                    $('#mbrbc-check-js').hide();
                    $("#barcodeNmbr").focus();
                }
            });
        }
    });

    // This event is called in the 'catalog/biblio_bulk_delete.php'
    $('input#biblio-bulk-delete').click(function(e) {
        $('div#message').hide();
        $('div#form-select-biblio').hide();
        $('div#pagination').hide();

        var el_lis = '';
        var chks = $('input[name*="chk-"]');
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                el_lis += '<li>';
                el_lis += $(chks[i]).parent().parent().children().eq(1).children().eq(0).html();
                author = jQuery.trim($(chks[i]).parent().parent().children().eq(2).html());
                if (author != "") {
                    el_lis += ' ('+ author +')';
                }
                el_lis += '</li>';
            }
        }
        var el_ul = $('ul#list-deleted-items'); 
        el_ul.html(el_lis);

        var el_confirm = $('div#form-confirm');
        el_confirm.show();
    });

    /**
     * Working on page loads ----------------------------------------------------
     */

    $("fieldset.collapsible").collapse({'closed': true, 'callback': change_legend_icon});
    change_legend_icon();


    var elm_keyword_type = $("span#form_biblio_search_keyword_types_1");
    var elm_keyword_text = $("span#form_biblio_search_keyword_text_1");
    elm_keyword_type.html(form_biblio_search_keyword_types());
    elm_keyword_text.html(form_biblio_search_keyword_text());
    row_count++;

    var elm_keyword_type = $("span#form_biblio_search_keyword_types_2");
    var elm_keyword_text = $("span#form_biblio_search_keyword_text_2");
    var elm_expression = $("span#form_biblio_search_expressions_2");
    var elm_add_field = $("span#form_biblio_search_add_field_2");
    elm_keyword_type.html(form_biblio_search_keyword_types());
    elm_keyword_text.html(form_biblio_search_keyword_text());
    elm_expression.html(form_biblio_search_expressions());
    elm_add_field.html(form_biblio_search_add_field());
    row_count++;
});
