$(document).ready(function() {

    $('#categories_table').DataTable({
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
        "ajax": {
            "url": "/categories/get-paginated-categories-data",
            "type": "GET",
            "dataSrc": function (json) {
                console.log("Server Response:", json); // Log the JSON response for debugging
                if (json && json.data) {
                    return json.data; // Return the data array to DataTables
                } else {
                    console.error("Error: Invalid JSON response from server.");
                    infoDangerAlert();
                    return []; // Return empty array to DataTables if no valid data
                }
            },
            "error": function (xhr, error, thrown) {
                console.error("DataTables AJAX Error:", error, thrown);
                console.error(xhr.responseText); // Log detailed error message
                infoDangerAlert();
            }
        },
        "columns": [
            { "data": "id" },

            { "data": "name_en" },
            { "data": "name_ar" },

            {
              "data": null,
              "render": function (data, type, row) {
                  return data.is_active == 1 ? yesText : noText;
              },
            },
            {
              "data": null,
              "render": function (data, type, row) {
                  return '<button class="btn btn-primary" onclick="redirectToUpdateCategory(' + data.id + ')">' + updateText + '</button>';
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

  function redirectToUpdateCategory(id) {
      window.location.href = '/categories/update-category/' + id;
  }

