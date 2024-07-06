<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Dashboards'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboards <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-12">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p>Elhashemya Group Admin Panel </p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="<?php echo e(URL::asset('/build/images/profile-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="<?php echo e(isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/build/images/users/avatar-1.jpg')); ?>" alt="" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"><?php echo e(Str::ucfirst(Auth::user()->name)); ?></h5>
                        <p class="text-muted mb-0 text-truncate">Admin</p>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15"><?php echo e($new_messages); ?></h5>
                                    <p class="text-muted mb-0">New Messages</p>
                                </div>

                                
                            </div>
                            <div class="mt-4">
                                <a href="<?php echo e(route('showMessages')); ?>" class="btn btn-primary waves-effect waves-light btn-sm">View  <i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15"><?php echo e($messages_count); ?></h5>
                                    <p class="text-muted mb-0">All Messages</p>
                                </div>

                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<!-- end row -->

<!-- end modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- apexcharts -->
<script src="<?php echo e(URL::asset('/build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

<!-- dashboard init -->
<script src="<?php echo e(URL::asset('build/js/pages/dashboard.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/index.blade.php ENDPATH**/ ?>