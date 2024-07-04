<?php
    if ($type == 'partners'){
        $mainTitle = __('translation.partners');
        $title = __('translation.partner');
        $createTitle = __('translation.create_new_partner');
    }else if($type == 'clients'){
        $mainTitle = __('translation.clients');
        $title = __('translation.client');
        $createTitle = __('translation.create_new_client');
    }
?>



<?php $__env->startSection('title'); ?> <?php echo e($title); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo e($mainTitle); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo e($createTitle); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="new_partner_or_client">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="<?php echo e($type); ?>" id="type" name="type">
                    
                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <img alt="#" class="rounded-circle avatar-lg" id="image">
                        </div>
                        <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="sequence" class="form-label"><?php echo app('translator')->get('translation.sequence'); ?></label>
                        <input type="number" class="form-control" id="sequence" name="sequence" autofocus placeholder="<?php echo app('translator')->get('translation.enter_sequence'); ?>">
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.create'); ?></button>
                    </div>
                </form>
            </div>
        </div>
                
    </div>
</div>
<!-- end row -->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('build/js/partners-or-clients/create-new-partner-or-client.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/partners-or-clients/create-new-partner-or-client.blade.php ENDPATH**/ ?>