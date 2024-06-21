
<style>
    #loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px; /* Add padding for better readability */
        background: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
        z-index: 1050; /* Ensure it is on top of other elements */
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 90%; /* Optional: set a max-width to avoid overflow */
        width: auto; /* Set width to auto to wrap the text */
        text-align: center; /* Center align text */
        border-radius: 10px; /* Optional: add rounded corners */
        display: none;
    }
</style>

<!-- Add a loading spinner -->
<div id="loading-spinner">
    <!-- Use an animated icon or loading GIF here -->
       <?php echo app('translator')->get('translation.loading'); ?>
</div>


<script>
    
    function showLoading(){
        $('#loading-spinner').show();
        disableButtons();
    }
    
    function hideLoading(){
        $('#loading-spinner').hide();
        enableButtons();
    }
    
</script><?php /**PATH E:\elhashemya_group\resources\views/layouts/utils/loading.blade.php ENDPATH**/ ?>