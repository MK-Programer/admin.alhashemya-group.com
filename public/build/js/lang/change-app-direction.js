$('#rtl-mode-switch').on('click', function(event) {
    event.preventDefault();
    rtlSwitchMode();
    // Navigate to the URL specified in the <a> tag
    window.location.href = $(this).attr('href');
});

$('#ltr-mode-switch').on('click', function(event) {
    event.preventDefault();
    ltrSwitchMode();

    // Navigate to the URL specified in the <a> tag
    window.location.href = $(this).attr('href');
});