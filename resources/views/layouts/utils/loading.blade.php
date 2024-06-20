<!-- Add a loading spinner -->
<div id="loading-spinner" style="background-color:#A4A4A4;">
    <!-- Use an animated icon or loading GIF here -->
       @lang('translation.loading')
</div>


<script>
    
    function showLoading(){
        $('#loading-spinner').show();
    }
    
    function hideLoading(){
        $('#loading-spinner').hide();
    }
    
</script>