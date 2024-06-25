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

function validateForm() {
    
    var errList = [];
    
    //gets table
    var oTable = document.getElementById('services_table');
    //gets rows of table
    var rowLength = oTable.rows.length;
    
    if(count != copyLimit){

        if(currentLang === 'ar'){
            errList = 'برجاء إنشاء ' + copyLimit + ' خدمات'; 
        }else if(currentLang === 'en'){
            errList = 'Please, Create ' + copyLimit + ' Services'; 
        }
        return errList;
    }else{
        
         // Loop through each row in the table
    for (var i = 1; i < rowLength; i++) {
        var oCells = oTable.rows.item(i).cells;

        // Validate each input/textarea in the row
        var inputsValid = true;
        $(oCells).find('input[type="text"], input[type="number"], textarea').each(function () {
            if (!$(this).val().trim()) {
                inputsValid = false;
            }
        });

        if (!inputsValid) {
            var message = currentLang === 'ar' ? 'برجاء التأكد من أن جميع الحقول في الصف ' + i + ' ممتلئة' : 'Please, Make Sure That All Inputs In Row ' + i + ' Are Filled';
            errList.push(message);
        }

        // Validate file inputs and corresponding hidden inputs
        $(oCells).each(function () {
            var hiddenInput = $(this).find('input[type="hidden"][name="hidden_picture[]"]').val();
            var fileInput = $(this).find('input[type="file"][name="new_picture[]"]')[0];

            if (!hiddenInput && fileInput) {
                if (!fileInput.files || !fileInput.files.length) {
                    var message = currentLang === 'ar' ? 'برجاء تحميل صورة في الصف ' + i : 'Please, Upload An Image in Row ' + i;
                    errList.push(message);
                } else {
                    var file = fileInput.files[0];
                    if (file) {
                        var fileType = file.type;
                        var validImageTypes = ["image/jpeg", "image/png", "image/gif"];
                        if (!validImageTypes.includes(fileType)) {
                            var message = currentLang === 'ar' ? 'برجاء التأكد من أن الملف في الصف ' + i + ' صورة' : 'Please, Make Sure That The File in Row ' + i + ' Is An Image';
                            errList.push(message);
                        }
                    }
                }
            }
        });
    }

        
        
        if(errList.length > 0){
            return errList;
        }else{
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

    // Append file inputs manually to FormData
    var fileInputs = $('input[type="file"]');
    for(var i = 0; i < fileInputs.length; i++){
        console.log(fileInputs[i].id);
        var files = fileInputs[i].files;
        if (files.length == 0) {
            formData.append('new_picture[]', ''); // Append empty string if needed
        } else {
            formData.append('new_picture[]', files[0]);    
        }
    }
    
    // formData.getAll('new_picture[]').forEach(function(file) {
    //     console.log('File:', file);
    // });
    
    $.ajax({
        url: 'update-services',
        type: 'POST',
        data: formData,
        processData: false,  // Important: tell jQuery not to process the data
        contentType: false,  // Important: tell jQuery not to set contentType
        success: function(response) {
            console.log(response);
            hideLoading();
            // success message
            // Reload the page after 2 seconds (2000 milliseconds)
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        },
        error: function(xhr, status, error) {
            hideLoading();
            setDanger(error);
        }
    });
}

function createFetchedServices(services){
    try{

        for(var i = 0; i < services.length; i++){
            addRow();
        }

        //gets table
        var oTable = document.getElementById('services_table');
        var rowLength = oTable.rows.length;
        console.log(rowLength);
        //loops through rows   
        for (i = 1; i < rowLength; i++){
            var service = services[i-1];
            //gets cells of current row  
            var oCells = oTable.rows.item(i).cells;

            var hiddenIdElementId = oCells.item(0).querySelector("input[type='hidden']").id;
            $("#" + hiddenIdElementId).val(service['id']);
            
            var hiddenPicturesElementId = oCells.item(1).querySelector("input[type='hidden']").id;
            $("#" + hiddenPicturesElementId).val(service['picture']);

            var imgPicturesElementId = oCells.item(1).querySelector("img").id;
            $("#" + imgPicturesElementId).attr('src', service['picture']);

            var titleEnElementId = oCells.item(2).querySelector("input[type='text']").id;
            $("#" + titleEnElementId).val(service['title_en']);

            var titleArElementId = oCells.item(3).querySelector("input[type='text']").id;
            $("#" + titleArElementId).val(service['title_ar']);

            var descriptionEnElementId = oCells.item(4).querySelector("textarea").id;
            $("#" + descriptionEnElementId).val(service['description_en']);

            var descriptionArElementId = oCells.item(5).querySelector("textarea").id;
            $("#" + descriptionArElementId).val(service['description_ar']);

            var sequenceElementId = oCells.item(6).querySelector("input[type='number']").id;
            $("#" + sequenceElementId).val(service['sequence']);
            
        }
    }catch(e){
        setDanger(e.message);
    }
    
}