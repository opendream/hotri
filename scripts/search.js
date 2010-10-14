var row_count = 1;
$(document).ready(function() {

    /**
     * Functions ---------------------------------------------------------------
     */

    form_biblio_search_keyword_types = function() {
        return '<select name="keyword_type_' + row_count + '">' + 
               '  <option value="title" selected>' + 'Title' + '</option>' +
               '  <option value="author">' + 'Author' + '</option>' +
               '  <option value="subject">' + 'Subject' + '</option>' +
               '  <option value="isbn">' + 'ISBN' + '</option>' +
               '</select>';
    }

    form_biblio_search_keyword_text = function() {
        return '<input type="text" name="keyword_text_' + row_count + '" size="40" />';
    }

    form_biblio_search_expressions = function() {
        return '<select name="expression_' + row_count + '">' +
               '  <option value="and">AND</option>' +
               '  <option value="or">OR</option>' +
               '  <option value="not">NOT</option>' +
               '</select>';
    }
        
    form_biblio_search_add_field = function() {
        return '<a href="javascript:add_field();" title="Add another field" class="add_field">[+]</a>';
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
        window.location = "/opac/index.php";
    });

    /**
     * Working on page loads ----------------------------------------------------
     */

    $("fieldset.collapsible").collapse({closed: false, callback: change_legend_icon});
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
