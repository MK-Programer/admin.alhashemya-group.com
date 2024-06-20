<!-- Add a loading spinner -->
<div id="loading-spinner" style="background-color:#A4A4A4;">
    <!-- Use an animated icon or loading GIF here -->
       <?php echo app('translator')->get('translation.loading'); ?>
</div>


<script>
    
    function showLoading(){
        $('#loading-spinner').show();
    }
    
    function hideLoading(){
        $('#loading-spinner').hide();
    }
    
</script><?php /**PATH E:\elhashemya_group\resources\views/layouts/utils/loading.blade.php ENDPATH**/ ?>