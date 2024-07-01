$(document).ready(function() {

    $('#missions_and_visions_table').DataTable({
      //   "processing": true,
      //   "serverSide": true,
      //   "responsive": true,
  
        "ordering": false,
        "ajax": {
            "url": "/missions-and-visions/get-paginated-missions-and-visions-data",
            "type": "GET",
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
                console.error(xhr.error); // Log detailed error message
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
                  return '<button class="btn btn-light" onclick="redirectToMissionAndVisionDetails(' + data.id + ')">' + detailsText + '</button>';
              },
            },
            { 
                "data": null,
                "render": function (data, type, row) {
                    return '<button class="btn btn-primary" onclick="redirectToUpdateMissionAndVision(' + data.id + ')">' + updateText + '</button>';
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
  
function redirectToUpdateMissionAndVision(id) {
    // window.location.href = '/services/update-service/' + id;
}

function redirectToMissionAndVisionDetails(id) {
    // window.location.href = '/services/update-service/' + id;
}
  
  