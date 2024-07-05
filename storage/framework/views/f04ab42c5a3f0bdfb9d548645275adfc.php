<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_company'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($company->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.company'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_company'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_company">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="company_id" name="company_id" value="<?php echo e($company->id); ?>">

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="<?php echo e(asset($company->logo)); ?>">
                            <img src = "<?php echo e(asset($company->logo)); ?>" alt="#" class="rounded-circle avatar-lg" id="company_image">
                        </div>
                        <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->name_en); ?>" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->name_ar); ?>" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label"><?php echo app('translator')->get('translation.phone'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->phone); ?>" id="phone" name="phone" autofocus placeholder="<?php echo app('translator')->get('translation.enter_phone'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?php echo app('translator')->get('translation.email'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->email); ?>" id="email" name="email" autofocus placeholder="<?php echo app('translator')->get('translation.enter_email'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fb_link" class="form-label"><?php echo app('translator')->get('translation.fb_link'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->fb_link); ?>" id="fb_link" name="fb_link" autofocus placeholder="<?php echo app('translator')->get('translation.enter_fb_link'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="other_link" class="form-label"><?php echo app('translator')->get('translation.other_link'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($company->other_link); ?>" id="other_link" name="other_link" autofocus placeholder="<?php echo app('translator')->get('translation.enter_other_link'); ?>">
                    </div>


                    <div class="mb-3">
                        <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                            <option value="1" <?php echo e($company->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                            <option value="0" <?php echo e($company->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- end row -->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('build/js/companies/update-company.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/companies/update-company.blade.php ENDPATH**/ ?>