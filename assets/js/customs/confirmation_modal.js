var deleteUrl;

function open_confirmation_modal(url) {
    deleteUrl = url;
    $('#confirmation-modal').modal();
}

function confirm_delete() {
    if (deleteUrl) {
        console.log(deleteUrl);
        window.location.assign(deleteUrl);        
        $('#confirmation-modal').modal("hide");
        deleteUrl = "";
    }
}