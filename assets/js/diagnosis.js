$(document).ready(function () {
    $("#add_pdr_form").validate({
        rules: {
            description: {
                minlength: 10,
                required: true
            },
        },
        messages: {
            description: {
                required: "Please enter the description",
                minlength: "Description must have minimum 10 character"
            },
        }
    });
});