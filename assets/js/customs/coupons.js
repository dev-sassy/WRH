$(document).ready(function () {

    $('#coupon-table').dataTable({
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [7]
            }, {
                'bSortable': false,
                'aTargets': [1]
            },
        ]
    });

    $('#startDate').datetimepicker({
        autoclose: true,
        todayBtn: true,
        startDate: new Date()
    }).on('changeDate', function (ev) {
        if ($('#startDate').val() >= $('#expiryDate').val()) {
            $('#expiryDate').val('');
        }
        $('#expiryDate').datetimepicker('setStartDate', $('#startDate').val() ? $('#startDate').val() : new Date());
    });

    $('#expiryDate').datetimepicker({
        autoclose: true,
        startDate: new Date()
    });

    $("#add_coupon_form, #edit_coupon_form").validate({
        rules: {
            couponName: {
                minlength: 2,
                maxlength: 50,
                required: true,
                pattern: "^[a-zA-Z' ]+$"
            },
            couponCode: {
                required: true,
                pattern: '^[a-zA-Z0-9]+$'
            },
            startDate: {
                required: true
            },
            expiryDate: {
                required: true
            },
            couponLimit: {
                required: true,
                pattern: '^[0-9]+$'
            }
        },
        messages: {
            couponName: {
                required: "Please enter the coupon name.",
                minlength: "Coupon name must be atleast 2 chars long!",
                maxlength: "Coupon name must not be exceed 50 characters!",
                pattern: 'Only alphabate, space and single quote is allowed.'
            },
            couponCode: {
                required: "Please enter the coupon code.",
                pattern: "Only alpha-numeric is allowewd!"
            },
            startDate: {
                required: "Please enter the start date-time.",
            },
            expiryDate: {
                required: "Please enter the expiry date-time.",
            },
            couponLimit: {
                required: "Please enter the coupon limit.",
                pattern: "Only digit is allowed!"
            }
        }
    });

    $("#add_coupon_form #couponLimit, #edit_coupon_form #couponLimit").keydown(function (e) {
        // backspace, delete, Home - 35, End - 36, arrows - 37-40
        if (e.keyCode == 46 || e.keyCode == 8 || (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        } else {
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }
    });

});