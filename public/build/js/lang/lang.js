
let currentLang;

$.ajax({
    url: '/get-current-language', // Replace with your route to fetch current language
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        currentLang = response.language;
    },
    error: function(xhr, status, error) {
        currentLang = 'en';
    }
});
