$(document).ready(function () {

    $("#change_pass").validate({
        rules: {
            old_password: {
                required: true
            },
            password: {
                minlength: 6,
                maxlength: 15,
                required: true
            },
            re_password: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            old_password: {
                required: "Please enter the old password.",
            },
            password: {
                required: "Please enter the password.",
                minlength: "Password must contain 6 to 15 characters.",
                maxlength: "Password must contain 6 to 15 characters.",
            },
            re_password: {
                equalTo: "Your password is not matched.",
                required: "Please enter confirm password."
            }
        }
    });

    $('#update').click(function () {
        if ($('#mail_err').text() == "Invalid Password!")
        {
            $('#old_password').focus();
            return false;
        }

        var old_password = $("#old_password").val().trim();
        if (old_password !== '') {
            return check_for_valid_password();
        }

    });

    $('#old_password').keyup(function () {
        var old_password = $("#old_password").val();
        if (old_password === '') {
            $('#mail_err').removeClass('help-block');
            $('#mail_err').parent().removeClass('has-error');
            $('#mail_err').html('');
            $('#mail_err').hide();
        }
    });

    function check_for_valid_password() {
        var old_password = $("#old_password").val();
        if (old_password) {
            $.ajax({
                url: SITE_URL + "login/chk_for_old_pass",
                type: "POST",
                data: {old_password: old_password},
                success: function (data) {
                    if (data == 'Invalid Password!')
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
                        return true;
                    }
                }
            });
        }
        return false;
    }

    $('#old_password').blur(function () {
        return check_for_valid_password();
    });

});