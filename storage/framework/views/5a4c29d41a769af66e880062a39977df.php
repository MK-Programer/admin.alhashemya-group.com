<div id="alert" style="display:none"></div>

<script>
    function hideAlert(){
        $('#alert').empty();
        $('#alert').hide();
    }

    function alertHelper(msg){
        if (Array.isArray(msg)) {
            if(msg.length == 1){
                msg = msg[0];
            }
        }

        if(Array.isArray(msg)){
            // Create a new ul element
            var ulElement = $('<ul>');
            for(let i = 0; i < msg.length; i++){
                // Add some list items to the ul
                ulElement.append('<li>' + msg[i] + '</li>');
            }
    
            $('#alert').append(ulElement);
        }else{
            $('#alert').text(msg);
        }
        $('#alert').show();
        window.location.hash = '#alert';
    }
    
    function setSuccess(msg){
        alertHelper(msg);
        $("#alert").addClass("alert alert-success");
    }
    
    function setDanger(msg){
        alertHelper(msg);
        $("#alert").addClass("alert alert-danger");
    }
</script><?php /**PATH E:\elhashemya_group\resources\views/layouts/utils/success-danger.blade.php ENDPATH**/ ?>