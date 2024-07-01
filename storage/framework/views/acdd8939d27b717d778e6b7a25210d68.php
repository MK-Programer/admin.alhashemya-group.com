<!-- JAVASCRIPT -->
<script src="<?php echo e(asset('build/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/sweetalert2.min.js')); ?>"></script>


<script>
    // lang
    var currentLang = '<?php echo e(app()->getLocale()); ?>';
    // assetPath
    var assetPath = '<?php echo e(asset('')); ?>';

    var error = '<?php echo app('translator')->get('translation.error'); ?>';
    var error400 = '<?php echo app('translator')->get('translation.error_400'); ?>';
    var ok = '<?php echo app('translator')->get('translation.ok'); ?>';
</script>

<?php echo $__env->make('layouts.utils.buttons-handler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->yieldContent('script'); ?>

<!-- App js -->
<script src="<?php echo e(asset('build/js/app.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/companies/change-user-company.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/lang/change-app-direction.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/popups/danger.js')); ?>"></script>

<?php echo $__env->yieldContent('script-bottom'); ?><?php /**PATH E:\elhashemya_group\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>