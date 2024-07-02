<?php echo $__env->yieldContent('css'); ?>

<!-- Bootstrap Css -->
<link href="<?php echo e(asset('/build/css/bootstrap.min.css')); ?>" class="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo e(asset('/build/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo e(asset(app()->getLocale() == 'en' ? '/build/css/app.min.css' : '/build/css/app-rtl.min.css')); ?>" class="app-style" rel="stylesheet" type="text/css" />

<link href="<?php echo e(asset('/build/css/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo e(asset('/build/css/tables.css')); ?>" rel="stylesheet" type="text/css" />

<?php /**PATH E:\elhashemya_group\resources\views/layouts/head-css.blade.php ENDPATH**/ ?>