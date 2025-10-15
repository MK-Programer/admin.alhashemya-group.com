$(document).ready(function() {

    var selectedMessages = [];
    var exportOptions = {
        columns: authUserCompanyId != 3 ? [1, 2, 3, 4, 6, 7, 8] : [1, 2, 3, 4, 5, 6, 7, 8]
    };

    var dataURL = "/messages/get-paginated-messages-data";
    var table = $('#messages_table').DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        autoWidth: false,
        paginate: true,
        dom: 'Bfrtip', // Add this to enable buttons
        buttons: [{
            extend: 'excelHtml5',
            exportOptions: exportOptions,
            text: 'Excel',
            customizeData: function(data) {
                var params = table.ajax.params();
                params.length = -1; // Fetch all records
                params.start = 0;
                exportToExcel(params, data);

            }
        }],
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
            url: dataURL,
            type: "GET",
            data: function(d) {
                // Add additional parameters for server-side processing if needed
                d.search_value = d.search.value; // Search value from DataTables
                // Add custom filter values
                d.filter_from = $('#filter_from').val();
                d.filter_to = $('#filter_to').val();
                d.filter_is_reviewed = $('#filter_is_reviewed').val();
            },
            dataSrc: function(json) {
                // console.log("Server Response:", json); // Log the JSON response for debugging
                if (json && json.data) {
                    return json.data; // Return the data array to DataTables
                } else {
                    console.error("Error: Invalid JSON response from server.");
                    infoDangerAlert();
                    return []; // Return empty array to DataTables if no valid data
                }
            },
            error: function(xhr, error, thrown) {
                console.error("DataTables AJAX Error:", error, thrown);
                console.error(xhr); // Log detailed error message
                infoDangerAlert();
            }
        },
        columns: [{
                data: null,
                render: function(data, type, row) {
                    return '<input type="checkbox" class="message-checkbox" data-id="' + data.id + '" ' + '>';
                },
            },
            { data: "id" },
            { data: "sender_name" },
            { data: "sender_email" },
            { data: "phone_number" },
            { data: "product_id" },
            { data: "subject" },
            { data: "body" },
            {
                data: null,
                render: function(data, type, row) {
                    return data.is_checked == 1 ? yesText : noText;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return '<button class="btn btn-light" onclick="redirectToMessageDetails(\'' + data.encrypted_id + '\')">' + detailsText + '</button>';
                },
            },
        ],
        pageLength: 10,
        language: {
            url: "lang/datatables_" + currentLang + ".json" // Adjust language file URL dynamically
        },
        initComplete: function() {
            console.log("DataTables initialization complete.");
            attachEventHandlers();
            table.column(3).visible(false);
            table.column(4).visible(false);
            table.column(7).visible(false);
            if (authUserCompanyId != 3) {
                table.column(5).visible(false);
            }
        }
    });


    function exportToExcel(params, data) {
        $.ajax({
            url: dataURL,
            type: "GET",
            data: params,
            dataType: 'json',
            async: false, // Synchronous request to ensure data is retrieved before export
            success: function(response) {
                // Replace the current data with the full data set for export
                data.body = response.data.map(function(row) {
                    var rowData = [];

                    if (authUserCompanyId != 3) {
                        // Add only specific columns based on condition
                        rowData = [
                            row.id,
                            row.sender_name,
                            row.sender_email,
                            row.phone_number,
                            row.subject,
                            row.body,
                            row.is_checked == 1 ? yesText : noText
                        ];
                    } else {
                        // Add all columns
                        rowData = [
                            row.id,
                            row.sender_name,
                            row.sender_email,
                            row.phone_number,
                            row.product_id,
                            row.subject,
                            row.body,
                            row.is_checked == 1 ? yesText : noText
                        ];
                    }

                    return rowData;
                });
            },
            error: function(xhr, error, thrown) {
                console.error("DataTables Export AJAX Error:", error, thrown);
                console.error(xhr);
                infoDangerAlert();
            }
        });

    }

    // Event handler for filtering
    $('#btn-filter').click(function() {
        table.draw();
    });

    // Event handler for resetting filters
    $('#btn-reset').click(function() {
        $('#filter_from').val('');
        $('#filter_to').val('');
        $('#filter_is_reviewed').val('');
        table.draw();
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

            if (selectedMessages.length > 0) {
                $('#messages_review_status_form').show();
            } else {
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

        if (selectedMessages.length == 0) {
            hideLoading();
            enableButtons();
            infoDangerAlert();
        } else {
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
                    setDanger(error500);
                    enableButtons();
                }
            });
        }


    });


});


function redirectToMessageDetails(id) {
    window.location.href = '/messages/message-details/' + id;
}