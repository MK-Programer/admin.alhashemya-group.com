document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('picture');
    const picture = document.getElementById('company_image');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {

            // Create a temporary URL for the selected file and update the image src
            const imageUrl = URL.createObjectURL(file);
            picture.src = imageUrl;

            // Revoke the object URL after the image is loaded
            picture.onload = function() {
                URL.revokeObjectURL(imageUrl);
            };
        }
    });
});

$('#update_company').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    $.ajax({
        url: "/companies/save-updated-company",
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

                if (errors.hasOwnProperty('picture')) {
                    errorsList = errorsList.concat(errors['picture']);
                }
                if (errors.hasOwnProperty('name_en')) {
                    errorsList = errorsList.concat(errors['name_en']);
                }
                if (errors.hasOwnProperty('name_ar')) {
                    errorsList = errorsList.concat(errors['name_ar']);
                }

                if (errors.hasOwnProperty('phone')) {
                    errorsList = errorsList.concat(errors['phone']);
                }
                if (errors.hasOwnProperty('email')) {
                    errorsList = errorsList.concat(errors['email']);
                }
                if (errors.hasOwnProperty('fb_link')) {
                    errorsList = errorsList.concat(errors['fb_link']);
                }
                if (errors.hasOwnProperty('other_link')) {
                    errorsList = errorsList.concat(errors['other_link']);
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
