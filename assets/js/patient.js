$(document).ready(function () {
    $("#add_p_form").validate({
        rules: {
            firstname: {
                minlength: 2,
                maxlength: 20,
                required: true,
                pattern: '^[a-zA-Z]+$'
            },
            lastname: {
                minlength: 2,
                maxlength: 20,
                required: true,
                pattern: '^[a-zA-Z]+$'
            },
            username: {
                minlength: 2,
                maxlength: 10,
                required: true,
                // pattern:'^[a-zA-Z]+$'
            },
            p_email: {
                required: true,
                pattern: "^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@" + "[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$"
            },
            p_addr: {
                required: true,
                minlength: 10,
                maxlength: 100,
            },
            p_contact: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true,
                pattern: '^[0-9]+$'
            },
            p_eme_contact_num: {
                minlength: 10,
                number: true,
                maxlength: 10,
                pattern: '^[0-9]+$'
            }
        },
        messages: {
            firstname: {
                required: "Please enter the first name",
                minlength: "First name name must be between 2 and 10 characters!",
                maxlength: "First name must be between 2 and 10 characters!",
                pattern: "Please enter only alphabet characters"
            },
            lastname: {
                required: "Please enter the last name",
                minlength: "Last name must be between 2 and 10 characters!",
                maxlength: "Last name must be between 2 and 10 characters!",
                pattern: "Please enter only alphabet characters"
            },
            username: {
                required: "Please enter the user name",
                minlength: "User name must be between 2 and 10 characters!",
                maxlength: "User name must be between 2 and 10 characters!",
                //pattern: "Please enter only alphabet characters"
            },
            p_email: {
                required: "Please enter the email address",
                pattern: "Please enter valid email address"
            },
            p_addr: {
                required: "Please enter patient Address",
                minlength: "address must be between 10 and 100 characters!",
                maxlength: "address must be between 10 and 100 characters!"
            },
            p_contact: {
                minlength: "Please enter atleast 10 digit",
                maxlength: "Please enter atleast 10 digit",
                required: "Please enter mobile number",
                pattern: "Please enter digits only"
            },
            p_eme_contact_num: {
                minlength: "Please enter atleast 10 digit",
                maxlength: "Please enter atleast 10 digit",
                pattern: "Please enter digits only"
            },
        }
    });

    $('#add_p').click(function () {
        if ($('#mail_err').text() == "Email already exist")
        {
            $('#p_email').focus();
            return false;
        }

    });

    $('#p_email').blur(function () {
        if ($('#p_email').val() != "")
        {
            $.ajax({
                url: "../patient/chk_p_email",
                type: "POST",
                data: {id: this.value},
                success: function (data) {
                    if (data == 'Email already exist')
                    {
                        $(this).focus();
                        $('#mail_err').show();
                        $('#mail_err').addClass('error');
                        $('#mail_err').text(data);
                        return false;
                    }
                    else
                    {
                        $('#mail_err').removeClass('error');
                        $('#mail_err').text('');
                        $('#mail_err').hide();
                    }
                }
            });
        }
    });

});