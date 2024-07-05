$(document).ready(function() {

    $('#company_table').DataTable({
      //   "processing": true,
      //   "serverSide": true,
      //   "responsive": true,

        "ordering": false,
        "ajax": {
            "url": "/companies/get-paginated-companies-data",
            "type": "GET",
            "dataSrc": function (json) {
                console.log("Server Response:", json); // Log the JSON response for debugging
                if (json && json.data) {
                    var perPage = json.per_page || 10; // Default per page value
                    var table = $('#company_table').DataTable();
                    table.page.len(perPage).draw(); // Adjust pagination length
                    return json.data; // Return the data array to DataTables
                } else {
                    console.error("Error: Invalid JSON response from server.");
                    return []; // Return empty array to DataTables if no valid data
                }
            },
            "error": function (xhr, error, thrown) {
                console.error("DataTables AJAX Error:", error, thrown);
                console.error(xhr.responseText); // Log detailed error message
            }
        },
        "columns": [
            { "data": "id" },
            {
              "data": "picture",
              "render": function (data, type, row) {
                  // Assuming picture_path is a relative path to the image
                  return '<img src="' + data + '" alt="#" class="img-thumbnail" style="max-width:100px;max-height:100px;">';
              }
            },
            { "data": "name_en" },
            { "data": "name_ar" },
            { "data": "email" },
            { "data": "phone" },
            {
              "data": null,
              "render": function (data, type, row) {
                  return data.is_active == 1 ? yesText : noText;
              },
            },
            {
              "data": null,
              "render": function (data, type, row) {
                  return '<button class="btn btn-primary" onclick="redirectToUpdateCompany(' + data.id + ')">' + updateText + '</button>';
              },
            },

        ],
        "language": {
            "url": "lang/datatables_" + currentLang + ".json" // Adjust language file URL dynamically
        },

        "initComplete": function () {
            console.log("DataTables initialization complete...");
        }
    });
  });

  function redirectToUpdateCompany(id) {
      window.location.href = '/companies/update-company/' + id;
  }

