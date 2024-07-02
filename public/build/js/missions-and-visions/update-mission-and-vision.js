document.addEventListener('DOMContentLoaded', function() {
    const missionFileInput = document.getElementById('mission_picture');
    const missionPicture = document.getElementById('mission_image');

    missionFileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {

            // Create a temporary URL for the selected file and update the image src
            const imageUrl = URL.createObjectURL(file);
            missionPicture.src = imageUrl;

            // Revoke the object URL after the image is loaded
            missionPicture.onload = function() {
                URL.revokeObjectURL(imageUrl);
            };
        } 
    });


    const visionFileInput = document.getElementById('vision_picture');
    const visionPicture = document.getElementById('vision_image');

    visionFileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {

            // Create a temporary URL for the selected file and update the image src
            const imageUrl = URL.createObjectURL(file);
            visionPicture.src = imageUrl;

            // Revoke the object URL after the image is loaded
            missionPicture.onload = function() {
                URL.revokeObjectURL(imageUrl);
            };
        } 
    });
});

$('#update_mission_vision_form').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);

    $.ajax({
        url: "/missions-and-visions/save-updated-mission-and-vision",
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

                if (errors.hasOwnProperty('mission_picture')) {
                    errorsList = errorsList.concat(errors['mission_picture']);
                }
                if (errors.hasOwnProperty('mission_title_en')) {
                    errorsList = errorsList.concat(errors['mission_title_en']);
                }
                if (errors.hasOwnProperty('mission_title_ar')) {
                    errorsList = errorsList.concat(errors['mission_title_ar']);
                }
                if (errors.hasOwnProperty('mission_description_en')) {
                    errorsList = errorsList.concat(errors['mission_description_en']);
                }
                if (errors.hasOwnProperty('mission_description_ar')) {
                    errorsList = errorsList.concat(errors['mission_description_ar']);
                }

                if (errors.hasOwnProperty('vision_picture')) {
                    errorsList = errorsList.concat(errors['vision_picture']);
                }
                if (errors.hasOwnProperty('vision_title_en')) {
                    errorsList = errorsList.concat(errors['vision_title_en']);
                }
                if (errors.hasOwnProperty('vision_title_ar')) {
                    errorsList = errorsList.concat(errors['vision_title_ar']);
                }
                if (errors.hasOwnProperty('vision_description_en')) {
                    errorsList = errorsList.concat(errors['vision_description_en']);
                }
                if (errors.hasOwnProperty('vision_description_ar')) {
                    errorsList = errorsList.concat(errors['mission_description_ar']);
                }

                if (errors.hasOwnProperty('sequence')) {
                    errorsList = errorsList.concat(errors['sequence']);
                }

                setDanger(errorsList);
            } else {
                setDanger(error);
            }
            enableButtons();
        }
    });
});