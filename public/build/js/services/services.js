let count = 0;                         // Track how many copies we have
let $template = $('#div-copy');         // The HTML you want to copy each time
let $container = $('#copy-container');     // Where the copies should be added
let $copy;
$('#services_table tbody tr:first-child').remove(); // remove the first row in the table after taking a copy from it

let copyLimit = 3;

function addRow() {
    try{
        hideAlert();
        if(count < copyLimit){
            // Increment our counter
            count++;
            
            // Create a copy of your base HTML/select
            let $copy = $template.clone();
            var img = $copy.find('img');
            var inputs = $copy.find('input');
            var textArea = $copy.find('textarea');
            
            // console.log(dropdowns);
            for(var i = 0; i < img.length; i++){
                img[i].id =  uniqueId();
            }
            
            for(var i = 0; i < inputs.length; i++){
                inputs[i].id =  uniqueId();
            }
            
            for(var i = 0; i < textArea.length; i++){
                textArea[i].id =  uniqueId();
            }

            // console.log($copy.innerHTML);
            // Append it
            $container.append($copy);
            
            // console.log($copy);
            
            $($copy).show();
        }else {
            if(currentLang === 'en'){
                setDanger('Only ' + copyLimit + ' Rows Can Be Created');
            }else if(currentLang === 'ar'){
                setDanger('لا يمكن إنشاء غير ' + copyLimit + ' صفوف');
            }
        }
        
        
        
        if(count > 0){
            $('#remove').show();
        }
    }catch(e){
        setDanger(e.message);
    }
}


function deleteRow() {
    try {
        hideAlert();
        var checkCount = 0;
        var doc = document.querySelectorAll('#div-copy');
        // console.log(doc);
        doc.forEach(x => {
            if(x.querySelector('input').checked){
                checkCount++;
            }
        });

        if(checkCount >= 1){
                doc.forEach(x => {
                if(x.querySelector('input').checked){
                    x.remove();
                    count--;
                }
            })
        }

        if(count == 0){
            $('#remove').hide();
        }
    }catch(e) {
        setDanger(e.message);
    }
}

// function validateForm() {
    
//     var errList = [];
    
//     //gets table
//     var oTable = document.getElementById('services_table');
//     //gets rows of table
//     var rowLength = oTable.rows.length;
    
//     if(count != copyLimit){

//         if(currentLang === 'ar'){
//             errList = 'برجاء إنشاء ' + copyLimit + ' خدمات'; 
//         }else if(currentLang === 'en'){
//             errList = 'Please, Create ' + copyLimit + ' Services'; 
//         }
//         return errList;
//     }else{
        
//          // Loop through each row in the table
//     for (var i = 1; i < rowLength; i++) {
//         var oCells = oTable.rows.item(i).cells;

//         // Validate each input/textarea in the row
//         var inputsValid = true;
//         $(oCells).find('input[type="text"], input[type="number"], textarea').each(function () {
//             if (!$(this).val().trim()) {
//                 inputsValid = false;
//             }
//         });

//         if (!inputsValid) {
//             var message = currentLang === 'ar' ? 'برجاء التأكد من أن جميع الحقول في الصف ' + i + ' ممتلئة' : 'Please, Make Sure That All Inputs In Row ' + i + ' Are Filled';
//             errList.push(message);
//         }

//         // Validate file inputs and corresponding hidden inputs
//         $(oCells).each(function () {
//             var hiddenInput = $(this).find('input[type="hidden"][name="hidden_picture[]"]').val();
//             var fileInput = $(this).find('input[type="file"][name="new_picture[]"]')[0];

//             if (!hiddenInput && fileInput) {
//                 if (!fileInput.files || !fileInput.files.length) {
//                     var message = currentLang === 'ar' ? 'برجاء تحميل صورة في الصف ' + i : 'Please, Upload An Image in Row ' + i;
//                     errList.push(message);
//                 } else {
//                     var file = fileInput.files[0];
//                     if (file) {
//                         var fileType = file.type;
//                         var validImageTypes = ["image/jpeg", "image/png", "image/gif"];
//                         if (!validImageTypes.includes(fileType)) {
//                             var message = currentLang === 'ar' ? 'برجاء التأكد من أن الملف في الصف ' + i + ' صورة' : 'Please, Make Sure That The File in Row ' + i + ' Is An Image';
//                             errList.push(message);
//                         }
//                     }
//                 }
//             }
//         });
//     }

        
        
//         if(errList.length > 0){
//             return errList;
//         }else{
//             return [];
//         }
//     }
// }

function updateImagePreview(event) {
    var fileInput = event.target;
    var imgElement = fileInput.closest('td').querySelector('img');
    
    if (fileInput.files && fileInput.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        imgElement.src = e.target.result;
      };
      
      reader.readAsDataURL(fileInput.files[0]);
    } else {
      imgElement.src = ''; // Clear the image source if no file is selected
    }
}

function validateForm() {
    var errList = [];
    var oTable = document.getElementById('services_table');
    var rowLength = oTable.rows.length;
  
    if (count != copyLimit) {
      if (currentLang === 'ar') {
        errList = 'برجاء إنشاء ' + copyLimit + ' خدمات';
      } else if (currentLang === 'en') {
        errList = 'Please, Create ' + copyLimit + ' Services';
      }
      return errList;
    } else {
      for (var i = 1; i < rowLength; i++) {
        var oCells = oTable.rows.item(i).cells;
        var missingInputs = [];
        var unsupportedImageTypes = [];

        var hiddenInput = $(oCells).find('input[type="hidden"][name="hidden_picture[]"]').val();
        var fileInput = $(oCells).find('input[type="file"][name="new_picture[]"]')[0];
  
        if (!hiddenInput && fileInput) {
          if (!fileInput.files || !fileInput.files.length) {
            var columnHeader = $(oTable.rows[0].cells[$(fileInput).closest('td').index()]).text().trim();
            missingInputs.push(columnHeader);
          } else {
            var file = fileInput.files[0];
            if (file) {
              var fileType = file.type;
              var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];
              if (!validImageTypes.includes(fileType)) {
                unsupportedImageTypes.push(fileType);
              }
            }
          }
        }
  
        $(oCells).find('input[type="text"], input[type="number"], textarea').each(function() {
          if (!$(this).val().trim()) {
            var columnHeader = $(oTable.rows[0].cells[$(this).closest('td').index()]).text().trim();
            missingInputs.push(columnHeader);
          }
        });

        if (missingInputs.length > 0 || unsupportedImageTypes.length > 0) {
          var message = '';
          if (missingInputs.length > 0) {
            message += currentLang === 'ar' ? 'برجاء التأكد من ملء جميع الحقول في الصف ' + i + ': ' + missingInputs.join(', ') : 'Please, make sure to fill all fields in row ' + i + ': ' + missingInputs.join(', ');
          }
  
          if (unsupportedImageTypes.length > 0) {
            var supportedTypesMessage = currentLang === 'ar' ? 'التنسيقات المدعومة: ' + validImageTypes.join(', ') : 'Supported formats: ' + validImageTypes.join(', ');
            if (message.length > 0) {
              message += ' | ';
            }
            message += currentLang === 'ar' ? 'برجاء التأكد من أن الملف في الصف ' + i + ' يكون من أحد التنسيقات التالية: ' + supportedTypesMessage : 'Please, make sure the file in row ' + i + ' is one of the following formats: ' + supportedTypesMessage;
          }
          errList.push(message);
        }
      }
  
      if (errList.length > 0) {
        return errList;
      } else {
        return [];
      }
    }
}

$('#services_form').on('submit', function(event) {
       
    try{
        event.preventDefault();  // Prevent the form from submitting the default way
        hideAlert();
        showLoading();

        var errList = validateForm();
        if(errList.length > 0){
            hideLoading();
            setDanger(errList);
        }else{
            submitServicesForm();
        }
    }catch(e){
        hideLoading();
        setDanger(e);
    }
});

function submitServicesForm(){

    // Create FormData object to hold all form data
    var formData = new FormData($('#services_form')[0]); // Serialize entire form data
  
    formData.delete('new_picture[]');

    // Select all file inputs
    let fileInputs = $('input[type="file"][name="new_picture[]"]');
    // Loop through each file input to ensure correct order
    fileInputs.each(function(index, fileInput) {
        let files = $(fileInput).prop('files');
        console.log(files);
        if (files.length === 0) {
            formData.append('new_picture[]', JSON.stringify({'file': null})); // Append null if no file selected
        } else {
            formData.append('new_picture[]', JSON.stringify({'file': files[0]})); // Append selected file
        }
    });
    hideLoading();
    console.log(formData.getAll('new_picture[]').length);
    // return;
    formData.getAll('new_picture[]').forEach(function(file) {
        console.log('File:', file);
    });

    // console.log(formData);
    $.ajax({
        url: 'update-services',
        type: 'POST',
        data: formData,
        processData: false,  // Important: tell jQuery not to process the data
        contentType: false,  // Important: tell jQuery not to set contentType
        success: function(response) {
            console.log(response)
            var msg = response['message'];

            hideLoading();
            setSuccess(msg);

            // Reload the page after 2 seconds (2000 milliseconds)
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            hideLoading();
            setDanger(error);
        }
    });
}

function createFetchedServices(assetPath, services){
    try{

        services.forEach(() => addRow());
        $('#services_table tbody tr').each((i, row) => {
            let service = services[i];
            $(row).find('input[type="hidden"][name="id[]"]').val(service.id);
            $(row).find('input[type="hidden"][name="hidden_picture[]"]').val(`${assetPath}${service.picture}`);
            $(row).find('img').attr('src', `${assetPath}${service.picture}`);
            $(row).find('input[name="title_en[]"]').val(service.title_en);
            $(row).find('input[name="title_ar[]"]').val(service.title_ar);
            $(row).find('textarea[name="description_en[]"]').val(service.desc_en);
            $(row).find('textarea[name="description_ar[]"]').val(service.desc_ar);
            $(row).find('input[name="sequence[]"]').val(service.sequence);
        });
    }catch(e){
        setDanger(e.message);
    }
    
}