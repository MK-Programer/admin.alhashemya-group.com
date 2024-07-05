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



$('#update_home').on('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "/home/home-update",
        type: "post",
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

                if (errors.hasOwnProperty('description_en')) {
                    errorsList = errorsList.concat(errors['description_en']);
                }
                // alert(22);

                setDanger(errorsList);
            } else {
                setDanger(error);
            }
        }
    });
});
