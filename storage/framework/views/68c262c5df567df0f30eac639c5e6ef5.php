<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
            <h5 class="m-0 me-2"><?php echo app('translator')->get('translation.settings'); ?></h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <div class="p-4">
            <div class="mb-4 text-center">
                <h5><?php echo app('translator')->get('translation.choose_theme'); ?></h5>
            </div>
        
            <div class="theme-selection">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="radio" name="theme" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch"><?php echo app('translator')->get('translation.light_theme'); ?></label>
                </div>
        
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="radio" name="theme" id="dark-mode-switch" data-bsStyle="build/css/bootstrap-dark.min.css" data-appStyle="build/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch"><?php echo app('translator')->get('translation.dark_theme'); ?></label>
                </div>
        
                
            </div>
        </div>
        

        
    </div>


    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/layouts/right-sidebar.blade.php ENDPATH**/ ?>