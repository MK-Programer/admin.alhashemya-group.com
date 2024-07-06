<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_category'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($category->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.categories'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_category'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_category">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="category_id" name="category_id" value="<?php echo e($category->id); ?>">


                    <div class="mb-3">
                        <label for="name_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($category->name_en); ?>" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($category->name_ar); ?>" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                    </div>


                    <div class="mb-3">
                        <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                            <option value="1" <?php echo e($category->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                            <option value="0" <?php echo e($category->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
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

<script src="<?php echo e(asset('build/js/categories/update-category.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/categories/update-category.blade.php ENDPATH**/ ?>