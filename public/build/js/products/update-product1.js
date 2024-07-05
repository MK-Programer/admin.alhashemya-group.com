document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('picture');
    const picture = document.getElementById('product_image');

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


$('#update_product').on('submit', function(event) {

    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);
    $.ajax({
        url: "/products/save-updated-product",
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
                if (errors.hasOwnProperty('title_en')) {
                    errorsList = errorsList.concat(errors['title_en']);
                }
                if (errors.hasOwnProperty('title_ar')) {
                    errorsList = errorsList.concat(errors['title_ar']);
                }
                if (errors.hasOwnProperty('description_en')) {
                    errorsList = errorsList.concat(errors['description_en']);
                }
                if (errors.hasOwnProperty('description_ar')) {
                    errorsList = errorsList.concat(errors['description_ar']);
                }
                if (errors.hasOwnProperty('is_active')) {
                    errorsList = errorsList.concat(errors['is_active']);
                }

                setDanger(errorsList);
            } else {
                setDanger(error);
            }
            enableButtons();
        }
    });
});
