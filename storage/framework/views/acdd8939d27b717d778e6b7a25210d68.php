<!-- JAVASCRIPT -->
<script src="<?php echo e(URL::asset('build/libs/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/metismenu/metisMenu.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>

<!-- lang -->
<script>
    var currentLang = '<?php echo e(app()->getLocale()); ?>';
</script>


<?php echo $__env->make('layouts.utils.buttons-handler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->yieldContent('script'); ?>

<!-- App js -->
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

<?php echo $__env->yieldContent('script-bottom'); ?><?php /**PATH E:\elhashemya_group\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>