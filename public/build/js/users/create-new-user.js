$('#new_user').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    $.ajax({
        url: "/users/save-created-user",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
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
                if (errors.hasOwnProperty('avatar')) {
                    errorsList = errorsList.concat(errors['avatar']);
                }
                if (errors.hasOwnProperty('name')) {
                    errorsList = errorsList.concat(errors['name']);
                }
                if (errors.hasOwnProperty('email')) {
                    errorsList = errorsList.concat(errors['email']);
                }
                if (errors.hasOwnProperty('password')) {
                    errorsList = errorsList.concat(errors['password']);
                }
                if (errors.hasOwnProperty('groups')) {
                    errorsList = errorsList.concat(errors['groups']);
                }


                setDanger(errorsList);
            } else {
                setDanger(error500);
            }
            enableButtons();
        }
    });
});