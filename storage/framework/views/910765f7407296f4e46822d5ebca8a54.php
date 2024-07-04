

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_service'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($service->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.services'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_service'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_service">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="service_id" name="service_id" value="<?php echo e($service->id); ?>">

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="<?php echo e($service->picture); ?>">
                            <img src = "<?php echo e(asset($service->picture)); ?>" alt="#" class="rounded-circle avatar-lg" id="service_image">
                        </div>
                        <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.title_en'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($service->title_en); ?>" id="title_en" name="title_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label"><?php echo app('translator')->get('translation.title_ar'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($service->title_ar); ?>" id="title_ar" name="title_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                        <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"><?php echo e($service->desc_en); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                        <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"><?php echo e($service->desc_ar); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="sequence" class="form-label"><?php echo app('translator')->get('translation.sequence'); ?></label>
                        <input type="number" class="form-control" value="<?php echo e($service->sequence); ?>" id="sequence" name="sequence" autofocus placeholder="<?php echo app('translator')->get('translation.enter_sequence'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                            <option value="1" <?php echo e($service->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                            <option value="0" <?php echo e($service->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
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

<script src="<?php echo e(asset('build/js/services/update-service.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/services/update-service.blade.php ENDPATH**/ ?>