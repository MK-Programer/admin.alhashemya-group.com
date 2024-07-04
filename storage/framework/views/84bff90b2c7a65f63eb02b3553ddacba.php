<?php
    if ($type == 'partners'){
        $mainTitle = __('translation.partners');
        $title = __('translation.update_partner');
    }else if($type == 'clients'){
        $mainTitle = __('translation.clients');
        $title = __('translation.update_client');
    }
?>



<?php $__env->startSection('title'); ?> <?php echo e($title); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($partnerOrClient->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo e($mainTitle); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo e($title); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_partner_or_client">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="id" name="id" value="<?php echo e($partnerOrClient->id); ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo e($type); ?>">
                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="<?php echo e($partnerOrClient->picture); ?>">
                            <img src = "<?php echo e(asset($partnerOrClient->picture)); ?>" alt="#" class="rounded-circle avatar-lg" id="image">
                        </div>
                        <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($partnerOrClient->title_en); ?>" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($partnerOrClient->title_ar); ?>" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="sequence" class="form-label"><?php echo app('translator')->get('translation.sequence'); ?></label>
                        <input type="number" class="form-control" value="<?php echo e($partnerOrClient->sequence); ?>" id="sequence" name="sequence" autofocus placeholder="<?php echo app('translator')->get('translation.enter_sequence'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                            <option value="1" <?php echo e($partnerOrClient->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                            <option value="0" <?php echo e($partnerOrClient->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
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

<script src="<?php echo e(asset('build/js/partners-or-clients/update-partner-or-client.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/partners-or-clients/update-partner-or-client.blade.php ENDPATH**/ ?>