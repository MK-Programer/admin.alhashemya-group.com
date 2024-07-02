$(document).ready(function() {

    $('#missions_and_visions_table').DataTable({
        // "serverSide": true,
        processing: true,
        responsive: true,
        autoWidth: false,
        paginate: true,
        lengthMenu: [10], // Display only one row per page
        createdRow: function(row, data, dataIndex) {
            $('td', row).css({
                'width': '150px',
                'word-wrap': 'break-word',
                'word-break': 'break-all',
                'white-space': 'normal',
                'overflow-wrap': 'break-word'
            });
        },
        "ordering": false,
        "ajax": {
            "url": "/missions-and-visions/get-paginated-missions-and-visions-data",
            "type": "GET",
            "data": function (d) {
                // Add start and length parameters for server-side pagination
                d.start = d.start || 0;
                d.length = d.length || 1; // Default length per page
                return d;
            },
            "dataSrc": function (json) {
                console.log("Server Response:", json); // Log the JSON response for debugging
                if (json && json.data) {
                    var perPage = json.per_page || 10; // Default per page value
                    var table = $('#services_table').DataTable();
                    table.page.len(perPage).draw(); // Adjust pagination length
                    return json.data; // Return the data array to DataTables
                } else {
                    console.error("Error: Invalid JSON response from server.");
                    return []; // Return empty array to DataTables if no valid data
                }
            },
            "error": function (xhr, error, thrown) {
                infoDangerAlert();
                console.error("DataTables AJAX Error:", error, thrown);
                console.error(xhr); // Log detailed error message
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "mission_title_en" },
            { "data": "mission_title_ar" },
            { "data": "vision_title_en" },
            { "data": "vision_title_ar" },
            { "data": "sequence" },
            { 
              "data": null,
              "render": function (data, type, row) {
                  return data.is_active == 1 ? yesText : noText;
              },
            },
            { 
              "data": null,
              "render": function (data, type, row) {
                  return '<button class="btn btn-light" onclick="redirectToRUMissionAndVision(\'' + data.id + '\', \'read\')">' + detailsText + '</button>';
              },
            },
            { 
                "data": null,
                "render": function (data, type, row) {
                    return '<button class="btn btn-primary" onclick="redirectToRUMissionAndVision(\'' + data.id + '\', \'update\')">' + updateText + '</button>';
                },
              },
        ],
        "language": {
            "url": "lang/datatables_" + currentLang + ".json" // Adjust language file URL dynamically
        }, 
        "initComplete": function () {
            console.log("DataTables initialization complete.");
        }
    });
});
  
function redirectToRUMissionAndVision(id, action) {
    window.location.href = '/missions-and-visions/ru-mission-and-vision-details/' + id + '/' + action;
}

  
  