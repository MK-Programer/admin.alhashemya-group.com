<style>
    
    .disabled-link {
        cursor: not-allowed;
        pointer-events: none;
    }
    
</style>

<script>
    
    function disableButtons(){
        $('button, input[type="button"], input[type="submit"], input[type="reset"]').attr('disabled', true);
        // Disable links
        $('a').each(function() {
            $(this).addClass('disabled-link');
        });
    }
    
</script><?php /**PATH E:\elhashemya_group\resources\views/layouts/utils/buttons-handler.blade.php ENDPATH**/ ?>