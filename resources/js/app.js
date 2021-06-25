require('./bootstrap');

require("jquery-validation");

// datatables
require("datatables.net-bs4");
require("datatables.net-responsive-bs4");
require("datatables.net-select-bs4");

// daterangepicker
window.moment = require('moment');
require('daterangepicker');

require("select2");

require("bootstrap-fileinput");
require("bootstrap-fileinput/themes/fas/theme");

require('./adminlte');

window.bootbox = require("bootbox");

// Select2 defaults
$.fn.select2.defaults.set("width", "100%");

// Datatable bootstrap class extend
$.extend(true, $.fn.dataTable.ext.classes, {
    sFilterInput: "form-control",
    sLengthSelect: "custom-select form-control"
});

// override jquery validate plugin defaults
$.validator.setDefaults({
    highlight: function (element) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
        $(element).removeClass('is-invalid');
    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback order-last");

        if (element.prop("type") === "select-one") {
            error.insertAfter(element.next("span"));
        } else if (element.prop("type") === "file") {
            error.insertAfter(element.parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});

// Delete confirmation
$(document).on("submit", "[delete-confirm]", function (e) {
    e.preventDefault();
    let currentForm = this;
    bootbox.confirm({
        title: "Delete",
        message: $(this).attr("delete-confirm"),
        centerVertical: true,
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Delete',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                currentForm.submit();
            }
        }
    });
});
