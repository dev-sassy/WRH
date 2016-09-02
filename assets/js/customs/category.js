$(document).ready(function () {

    $("#add_category_form, #edit_category_form").validate({
        rules: {
            categoryName: {
                minlength: 2,
                maxlength: 50,
                required: true,
                pattern: "^[a-zA-Z' ]+$"
            }
        },
        messages: {
            categoryName: {
                required: "Please enter the category name.",
                minlength: "Category name must be atleast 2 chars long!",
                maxlength: "Category name must not be exceed 50 characters!",
                pattern: 'Only alphabate, space and single quote is allowed.'
            }
        }
    });

});