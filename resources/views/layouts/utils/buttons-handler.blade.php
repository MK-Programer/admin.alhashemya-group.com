<style>
    
    .disabled-link {
        cursor: not-allowed;
        pointer-events: none;
    }
    
</style>

<script>

    function buttonsClickHelper(canClick){
        $('button, input[type="button"], input[type="submit"], input[type="reset"]').attr('disabled', !canClick);
        var linksClass = canClick ? '' : 'disabled-links'; 
        // Disable links
        $('a').each(function() {
            $(this).addClass(linksClass);
        });
    }
    
    function disableButtons(){
        buttonsClickHelper(false);
    }

    function enableButtons(){
        buttonsClickHelper(true)
    }
    
</script>