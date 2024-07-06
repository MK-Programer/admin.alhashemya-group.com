<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.create_new_company'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.company'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.create_new_company'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" id="update_company" data-action="<?php echo e(route('saveCreatedCompany')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><?php echo app('translator')->get('translation.phone'); ?></label>
                        <input type="number" class="form-control" id="phone" name="phone" autofocus placeholder="<?php echo app('translator')->get('translation.enter_phone'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?php echo app('translator')->get('translation.email'); ?></label>
                        <input type="email" class="form-control" id="email" name="email" autofocus placeholder="<?php echo app('translator')->get('translation.enter_email'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fb_link" class="form-label"><?php echo app('translator')->get('translation.fb_link'); ?></label>
                        <input type="text" class="form-control" id="fb_link" name="fb_link" autofocus placeholder="<?php echo app('translator')->get('translation.enter_fb_link'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="other_link" class="form-label"><?php echo app('translator')->get('translation.other_link'); ?></label>
                        <input type="text" class="form-control" id="other_link" name="other_link" autofocus placeholder="<?php echo app('translator')->get('translation.enter_other_link'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="formFile"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <input class="form-control" type="file" id="formFile" onChange="mainThamUrl(this)" name="picture">
                        <img class="mt-2" src="" id="mainThmb" alt="">
                    </div>

                    <div>
                        <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.create'); ?></button>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>


<script src="<?php echo e(asset('build/js/companies/create-new-company.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/companies/create-new-company.blade.php ENDPATH**/ ?>