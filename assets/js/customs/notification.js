$(document).ready(function () {
    $("#add_note_form").validate({
        rules: {
            event_date: {
                required: true
            },
            description: {
                minlength: 6,
                maxlength: 200,
                required: true,
            }
        },
        messages: {
            event_date: {
                required: "Event Date Required",
            },
            description: {
                required: "Description Required",
                minlength: "Description must be between 6 and 200 characters!",
                maxlength: "Description must be between 6 and 200 characters!",
            }
        }
    });

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    $('#event_date').datepicker({
        startDate: today
    });

});