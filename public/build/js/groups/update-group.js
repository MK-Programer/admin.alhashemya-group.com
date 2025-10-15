$('#update_group').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    $.ajax({
        url: "/groups/save-updated-group",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var msg = response['message'];

            hideLoading();
            setSuccess(msg);
            enableButtons();

            // Reload the page after 2 seconds (2000 milliseconds)
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            hideLoading();
            if (xhr.status === 422) {

                // Validation errors
                var errors = xhr.responseJSON.errors;
                console.log(errors);
                var errorsList = [];
                // Example handling for email and name errors

                if (errors.hasOwnProperty('name')) {
                    errorsList = errorsList.concat(errors['name']);
                }

                if (errors.hasOwnProperty('menu')) {
                    errorsList = errorsList.concat(errors['menu']);
                }

                if (errors.hasOwnProperty('is_active')) {
                    errorsList = errorsList.concat(errors['is_active']);
                }

                setDanger(errorsList);
            } else {
                setDanger(error500);
            }
            enableButtons();
        }
    });
});