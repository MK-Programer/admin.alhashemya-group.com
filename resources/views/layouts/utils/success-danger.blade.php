<div id="alert" style="display:none"></div>

<script>
    function hideAlert(){
        $('#alert').empty();
        $('#alert').hide();
    }

    function alertHelper(msg){
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
    }
    
    function setSuccess(msg){
        alertsHelper(msg);
        $("#alert").addClass("alert alert-success");
    }
    
    function setDanger(msg){
        alertsHelper(msg);
        $("#alert").addClass("alert alert-danger");
    }
</script>