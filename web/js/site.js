/*jslint browser: true*/
/*global $, jQuery, alert*/
$(document).ready(function () {
    'use strict';
    $("input[name*='CatalogSearch']")
        .addClass('hasclear')
        .wrap('<div class="form-group has-feedback">')
        .after('<span class="clearer glyphicon glyphicon-remove-circle form-control-feedback"></span>');
  
    $(".hasclear").keyup(function () {
        var t = $(this);
        t.next('span').toggle(Boolean(t.val()));
    });

    var clrButt = $(".clearer");
    
    clrButt.each(function () {
        var t = $(this);
        if (t.prev('input').val()) {
            t.show();
        } else {
            t.hide();
        }
    });

    clrButt.click(function () {
        $(this).prev('input').val('').change();
        $(this).hide();
//        $(this).prev('form').submit();
    });
});