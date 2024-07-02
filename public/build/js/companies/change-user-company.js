$(document).ready(function() {

    // Use event delegation to handle clicks on dynamically added elements
    $(document).on('click', '.company-link', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        // Get the clicked element
        let clickedElement = $(this);

        // Data to be sent to the server
        let data = {
            id: clickedElement.data('id')
        };

        $.ajax({
            url: '/user/update-user-company-id', // Replace with your server endpoint
            type: 'post', // Use POST or another method if necessary
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for security
            },
            success: function(response) {
                // Handle successful response
                console.log('Success:', response);
                // You can update the UI or perform other actions based on the response
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error:', error);
                console.error('Response:', xhr);
                infoDangerAlert();
            }
        });
    });
});