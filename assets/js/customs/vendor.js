$(document).ready(function () {
    
    $("#add_vendor_form, #edit_vendor_form").validate({
        rules: {
            vendorName: {
                minlength: 2,
                maxlength: 150,
                required: true,
                pattern: "^[a-zA-Z' ]+$"
            }
        },
        messages: {
            vendorName: {
                required: "Please enter the vendor name.",
                minlength: "Vendor name must be atleast 2 chars long!",
                maxlength: "Vendor name must not be exceed 150 characters!",
                pattern: 'Only alphabate, space and single quote is allowed.'
            }
        }
    });

});