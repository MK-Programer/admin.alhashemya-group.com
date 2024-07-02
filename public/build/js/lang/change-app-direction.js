$('#rtl-mode-switch').on('click', function(event) {
    event.preventDefault();
    rtlSwitchMode();
    // Navigate to the URL specified in the <a> tag
    // window.location.href = $(this).attr('href');
    changeDirAjaxReq($(this).attr('href'));
    
});

$('#ltr-mode-switch').on('click', function(event) {
    event.preventDefault();
    ltrSwitchMode();

    // Navigate to the URL specified in the <a> tag
    // window.location.href = $(this).attr('href');
    changeDirAjaxReq($(this).attr('href'));
});

function changeDirAjaxReq(url){
    $.ajax({
        url: url,
        type: "get",
        contentType: false,
        processData: false,
        success: function(response) {
            var msg = response['message'];
            window.location.reload();
            // console.log(msg);
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error:', error);
            console.error('Response:', xhr);
            infoDangerAlert();
        }
    });
}


