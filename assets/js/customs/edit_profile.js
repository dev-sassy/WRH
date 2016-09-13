$(document).ready(function () {

    $("#edit-profile").validate({
        rules: {
            firstname: {
                required: true,
                minlength: 2,
                maxlength: 25,
                pattern: '^[a-zA-Z]+$'
            },
            lastname: {
                required: true,
                minlength: 2,
                maxlength: 25,
                pattern: '^[a-zA-Z]+$'
            }
        },
        messages: {
            firstname: {
                required: "Please enter the first name.",
                minlength: "First name should be atleast 2 chars long!",
                maxlength: "First name should not exceed 25 chars!",
                pattern: "Only alphabate is allowed!"
            },
            lastname: {
                required: "Please enter the last name.",
                minlength: "Last name should be atleast 2 chars long!",
                maxlength: "Last name should not exceed 25 chars!",
                pattern: "Only alphabate is allowed!"
            }
        }
    });

    $('#update').click(function () {
        if ($('#mail_err').text() == "Invalid Password")
        {
            $('#old_password').focus();
            return false;
        }
    });

    $('#old_password').blur(function () {
        var old_password = $("#old_password").val();
        if (old_password) {
            $.ajax({
                url: SITE_URL + "login/chk_for_old_pass",
                type: "POST",
                data: {old_password: old_password},
                success: function (data) {
                    if (data == 'Invalid Password')
                    {
                        $(this).focus();
                        $('#mail_err').show();
                        $('#mail_err').addClass('help-block');
                        $('#mail_err').parent().addClass('has-error');
                        $('#mail_err').html(data);
                    }
                    else
                    {
                        $('#mail_err').removeClass('help-block');
                        $('#mail_err').parent().removeClass('has-error');
                        $('#mail_err').html('');
                        $('#mail_err').hide();
                    }
                }
            });
        }
        return false;
    });

});