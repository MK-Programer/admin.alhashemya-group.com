$(document).ready(function() {
    var selectedMessages = [];
   
    var table = $('#messages_table').DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        autoWidth: false,
        paginate: true,
        createdRow: function(row, data, dataIndex) {
            $('td', row).css({
                'width': '150px',
                'word-wrap': 'break-word',
                'word-break': 'break-all',
                'white-space': 'normal',
                'overflow-wrap': 'break-word'
            });
        },
        ordering: false,
        ajax: {
            url: "/messages/get-paginated-messages-data",
            type: "GET",
            data: function(d) {
                // Add additional parameters for server-side processing if needed
                d.searchValue = d.search.value; // Search value from DataTables
            },
            dataSrc: function (json) {
                console.log("Server Response:", json); // Log the JSON response for debugging
                if (json && json.data) {
                    return json.data; // Return the data array to DataTables
                } else {
                    console.error("Error: Invalid JSON response from server.");
                    infoDangerAlert();
                    return []; // Return empty array to DataTables if no valid data
                }
            },
            error: function (xhr, error, thrown) {
                console.error("DataTables AJAX Error:", error, thrown);
                console.error(xhr); // Log detailed error message
                infoDangerAlert();
            }
        },
        columns: [
            { 
                data: null,
                render: function (data, type, row){
                    return '<input type="checkbox" class="message-checkbox" data-id="' + data.id + '" '+'>';
                }
            },
            { data: "id" },
            { data: "sender_name" },
            { data: "product_id" },
            { data: "subject" },
            { 
              data: null,
              render: function (data, type, row){
                  return data.is_checked == 1 ? yesText : noText;
              }
            },
            { 
              data: null,
              render: function (data, type, row) {
                  return '<button class="btn btn-light" onclick="redirectToMessageDetails(' + data.id + ')">' + detailsText + '</button>';
              },
            },
        ],
        pageLength: 10,
        language: {
            url: "lang/datatables_" + currentLang + ".json" // Adjust language file URL dynamically
        }, 
        initComplete: function () {
            console.log("DataTables initialization complete.");
            attachEventHandlers();
        }
    });

    // Function to attach event handlers
    function attachEventHandlers() {
        // Handle individual checkbox changes
        $('#messages_table').on('change', '.message-checkbox', function() {
            var isChecked = $(this).prop('checked');
            var rowData = table.row($(this).closest('tr')).data();
            var rowId = rowData.id;

            // Update selectedMessages array based on checkbox state
            if (isChecked && selectedMessages.indexOf(rowId) === -1) {
                selectedMessages.push(rowId);
            } else if (!isChecked && selectedMessages.indexOf(rowId) !== -1) {
                selectedMessages.splice(selectedMessages.indexOf(rowId), 1);
            }

            if(selectedMessages.length > 0){
                $('#messages_review_status_form').show();
            }else{
                $('#messages_review_status_form').hide();
            }

            console.log(selectedMessages);
        });
    }

    $('#messages_review_status_form').on('submit', function(event) {
        event.preventDefault();
        showLoading();
        hideAlert();
        disableButtons();

        if(selectedMessages.length == 0){
            hideLoading();
            enableButtons();
            infoDangerAlert();
        }else{
            let formData = new FormData(this);
            formData.append('selectedMessages', JSON.stringify(selectedMessages));
            $.ajax({
                url: "/messages/change-message-reviewed-status",
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
                    hideLoading();
                    console.log(xhr);
                    setDanger(error);
                    enableButtons();
                }
            });
        }

        
    });


});

  
function redirectToMessageDetails(id) {
    window.location.href = '/messages/message-details/' + id;
}

  
  