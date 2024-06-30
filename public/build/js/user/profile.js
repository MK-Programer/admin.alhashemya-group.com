document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('avatar');
    const profileImage = document.getElementById('profile_image');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            
            // Create a temporary URL for the selected file and update the image src
            const imageUrl = URL.createObjectURL(file);
            profileImage.src = imageUrl;

            // Revoke the object URL after the image is loaded
            profileImage.onload = function() {
                URL.revokeObjectURL(imageUrl);
            };
        } 
    });
});


$('#update_user_profile').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    
    $.ajax({
        url: "/user/update-user-profile",
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
                
                setDanger(errorsList);
            } else {
                setDanger(error);
            }
            enableButtons();
        }
    });
});

$('#update_user_password').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    $.ajax({
        url: "/user/update-user-password",
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
            hideLoading();
            if (xhr.status === 422) {
                
                // Validation errors
                var errors = xhr.responseJSON.errors;
                console.log(errors);
                var errorsList = [];
                // Example handling for email and name errors
                
                if (errors.hasOwnProperty('current_password')) {
                    errorsList = errorsList.concat(errors['current_password']);
                }
                if (errors.hasOwnProperty('new_password')) {
                    errorsList = errorsList.concat(errors['new_password']);
                }
                if (errors.hasOwnProperty('new_password_confirmation')) {
                    errorsList = errorsList.concat(errors['new_password_confirmation']);
                }
                
                setDanger(errorsList);
            } else {
                console.log(xhr);
                setDanger(error);
            }
            enableButtons();
        }
    });
});