/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

// Language settings for English
var langEnglish = {
    "paginate": {
        "previous": "Previous",
        "next": "Next"
    },
    "emptyTable": "No data available in table",
    "zeroRecords": "No matching records found",
    "lengthMenu": "Show _MENU_ entries",
    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
    "infoEmpty": "Showing 0 to 0 of 0 entries",
    "infoFiltered": "(filtered from _MAX_ total entries)",
    "search": "Search:"
};

// Language settings for Arabic
var langArabic = {
    "paginate": {
        "previous": "السابق",
        "next": "التالى"
    },
    "emptyTable": "لا توجد بيانات متوفرة في الجدول",
    "zeroRecords": "لم يتم العثور على سجلات مطابقة",
    "lengthMenu": "عرض _MENU_ إدخالات",
    "info": "إظهار _START_ إلى _END_ من _TOTAL_ من الإدخالات",
    "infoEmpty": "إظهار 0 إلى 0 من 0 مدخلات",
    "infoFiltered": "(منتقاة من مجموع _MAX_ إدخال)",
    "search": "ابحث:"
};

var table; // Declare table variable for later assignment

function initializeDataTable(language) {
    if (table) {
        table.destroy(); // Destroy the current DataTable instance if it exists
    }

    var langSettings;
    var allTxt;

    if(language === 'ar'){
        langSettings =  langArabic;
        allTxt = 'الكل';
    }else if(language === 'en'){
        langSettings = langEnglish;
        allTxt = 'All';
    }
    

    table = $('#datatable').DataTable({
        "language": langSettings,
        "ordering": false,
        "columnDefs": [
            { className: "dt-center", targets: '_all' }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, allTxt]],
    });
}

// Function to get current language from session via AJAX
function getCurrentLanguage() {
    $.ajax({
        url: '/get-current-language', // Replace with your route to fetch current language
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response && response.language) {
                initializeDataTable(response.language);
            } else {
                initializeDataTable('en'); // Fallback to English if language not found
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching current language:', error);
            initializeDataTable('en'); // Fallback to English in case of error
        }
    });
}

$(document).ready(function() {
    // Call getCurrentLanguage on document ready
    getCurrentLanguage();
});