

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.error_404'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-2 fw-medium">4<i class="bx bx-buoy bx-spin text-primary display-3"></i>4</h1>
                        <h4 class="text-uppercase"><?php echo app('translator')->get('translation.error_404'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div>
                        <img src="<?php echo e(asset('build/images/error-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/errors/404.blade.php ENDPATH**/ ?>