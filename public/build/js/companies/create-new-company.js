$('#mainThmb').hide();

function mainThamUrl(input) {
    $('#mainThmb').show();
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#mainThmb').attr('src', e.target.result).width(100).height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
}


$('#update_company').on('submit', function(event) {
    event.preventDefault();
    showLoading();
    hideAlert();
    disableButtons();

    let formData = new FormData(this);

    $.ajax({
        url: "/companies/save-created-company",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var msg = response['message'];

            hideLoading();
            setSuccess(msg);
            enableButtons();

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
                // alert(22);

                setDanger(errorsList);
            } else {
                setDanger(error);
            }
        }
    });
});
