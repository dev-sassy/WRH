$(document).ready(function () {
    
    $('#notification-table').dataTable({
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [3]
            },
        ]
    });
    
    $("#add_note_form").validate({
        rules: {
            title: {
                required: true
            },
            description: {
                minlength: 6,
                maxlength: 200,
                required: true,
            }
        },
        messages: {
            title: {
                required: "Title is required.",
            },
            description: {
                required: "Description is required.",
                minlength: "Description must contain 6 to 200 characters.",
                maxlength: "Description must contain 6 to 200 characters.",
            }
        }
    });

});