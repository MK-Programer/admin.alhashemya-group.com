

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.dashboard'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.dashboard'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.dashboard'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-12">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary"><?php echo app('translator')->get('translation.welcome_back'); ?></h5>
                            <p> <?php echo app('translator')->get('translation.at_company'); ?> <?php echo e(app()->getLocale() == 'en' ? $authUser->company->name_en : $authUser->company->name_ar); ?></p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="<?php echo e(asset('/build/images/profile-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="<?php echo e(asset($authUser->avatar)); ?>" alt="#" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate"><?php echo e(Str::ucfirst($authUser->name)); ?></h5>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15"><?php echo e($newMessages); ?></h5>
                                    <p class="text-muted mb-0"><?php echo app('translator')->get('translation.new_messages'); ?></p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="<?php echo e(route('showMessages')); ?>" class="btn btn-primary waves-effect waves-light btn-sm"><?php echo app('translator')->get('translation.view'); ?><i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15"><?php echo e($messagesCount); ?></h5>
                                    <p class="text-muted mb-0"><?php echo app('translator')->get('translation.all_messages'); ?></p>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/index.blade.php ENDPATH**/ ?>