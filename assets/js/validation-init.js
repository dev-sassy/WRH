var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { alert("submitted!"); }
    });

    $().ready(function() {
       

        // validate Category form on keyup and submit
        $("#categoriesadd").validate({
            rules: {
				catname: "required",
				eventradio:"required"
            },
            messages: {
                Catname: "Please enter your firstname",
                eventradio: "The event / Category  is required"
            }
        });

        // user page form velidation
        $("#useraddform").validate({
            rules: {
				username: "required",
				password:"required",
				emailid:"required"
            },
            messages: {
				username: "Please enter username",
				password:"Please enter Password",
				emailid:"Please enter Email id"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();