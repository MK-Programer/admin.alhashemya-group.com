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


$('#new_product').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);

    $.ajax({

        url: "/products/save-created-product",
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
                if (errors.hasOwnProperty('description_en')) {
                    errorsList = errorsList.concat(errors['description_en']);
                }
                if (errors.hasOwnProperty('description_ar')) {
                    errorsList = errorsList.concat(errors['description_ar']);
                }
                if (errors.hasOwnProperty('model')) {
                    errorsList = errorsList.concat(errors['model']);
                }
                if (errors.hasOwnProperty('capacity')) {
                    errorsList = errorsList.concat(errors['capacity']);
                }
                if (errors.hasOwnProperty('length')) {
                    errorsList = errorsList.concat(errors['length']);
                }
                if (errors.hasOwnProperty('width')) {
                    errorsList = errorsList.concat(errors['width']);
                }
                if (errors.hasOwnProperty('height')) {
                    errorsList = errorsList.concat(errors['height']);
                }
                if (errors.hasOwnProperty('voltage')) {
                    errorsList = errorsList.concat(errors['voltage']);
                }
                if (errors.hasOwnProperty('total_height')) {
                    errorsList = errorsList.concat(errors['total_height']);
                }
                if (errors.hasOwnProperty('gross_weight')) {
                    errorsList = errorsList.concat(errors['gross_weight']);
                }

                setDanger(errorsList);
            } else {
                setDanger(error500);
            }
            enableButtons();
        }
    });
});
