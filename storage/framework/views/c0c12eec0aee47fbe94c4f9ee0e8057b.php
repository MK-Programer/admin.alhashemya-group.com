

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_mission_and_vision'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($mission->id. ' - '.$vision->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.missions_and_visions'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_mission_and_vision'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form class="form-horizontal" enctype="multipart/form-data" id="update_mission_vision_form">

            <input type="hidden" id="mission_id" name="mission_id" value="<?php echo e($mission->id); ?>">
            <input type="hidden" id="vision_id" name="vision_id" value="<?php echo e($vision->id); ?>">

            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title "><?php echo app('translator')->get('translation.mission'); ?></h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="mission_db_picture" name="mission_db_picture" value="<?php echo e(asset($mission->picture)); ?>">
                            <img src="<?php echo e(asset($mission->picture)); ?>" alt="#" class="rounded-circle avatar-lg" id="mission_image">
                        </div>
                        <label for="mission_picture"><?php echo app('translator')->get('translation.mission_picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="mission_picture" name="mission_picture" autofocus>
                            <label class="input-group-text" for="mission_picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_en" class="form-label"><?php echo app('translator')->get('translation.mission_title_en'); ?></label>
                        <input type="text" class="form-control" id="mission_title_en" name="mission_title_en" value="<?php echo e($mission->title_en); ?>" autofocus placeholder="<?php echo app('translator')->get('translation.enter_mission_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_ar" class="form-label"><?php echo app('translator')->get('translation.mission_title_ar'); ?></label>
                        <input type="text" class="form-control" id="mission_title_ar" name="mission_title_ar" value="<?php echo e($mission->title_ar); ?>" autofocus placeholder="<?php echo app('translator')->get('translation.enter_mission_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_en" class="form-label"><?php echo app('translator')->get('translation.mission_description_en'); ?></label>
                        <textarea class="form-control" id="mission_description_en" name="mission_description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_mission_description_en'); ?>"><?php echo e($mission->desc_en); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_ar" class="form-label"><?php echo app('translator')->get('translation.mission_description_ar'); ?></label>
                        <textarea class="form-control" id="mission_description_ar" name="mission_description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_mission_description_ar'); ?>"><?php echo e($mission->desc_ar); ?></textarea>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title "><?php echo app('translator')->get('translation.vision'); ?></h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="vision_db_picture" name="vision_db_picture" value="<?php echo e(asset($vision->picture)); ?>">
                            <img src="<?php echo e(asset($vision->picture)); ?>" alt="#" class="rounded-circle avatar-lg" id="vision_image">
                        </div>
                        <label for="vision_picture"><?php echo app('translator')->get('translation.vision_picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="vision_picture" name="vision_picture" autofocus>
                            <label class="input-group-text" for="vision_picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_en" class="form-label"><?php echo app('translator')->get('translation.vision_title_en'); ?></label>
                        <input type="text" class="form-control" id="vision_title_en" name="vision_title_en" value="<?php echo e($vision->title_en); ?>" autofocus placeholder="<?php echo app('translator')->get('translation.enter_vision_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_ar" class="form-label"><?php echo app('translator')->get('translation.vision_title_ar'); ?></label>
                        <input type="text" class="form-control" id="vision_title_ar" name="vision_title_ar" value="<?php echo e($vision->title_ar); ?>" autofocus placeholder="<?php echo app('translator')->get('translation.enter_vision_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_en" class="form-label"><?php echo app('translator')->get('translation.vision_description_en'); ?></label>
                        <textarea class="form-control" id="vision_description_en" name="vision_description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_vision_description_en'); ?>"><?php echo e($vision->desc_en); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_ar" class="form-label"><?php echo app('translator')->get('translation.vision_description_ar'); ?></label>
                        <textarea class="form-control" id="vision_description_ar" name="vision_description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_vision_description_ar'); ?>"><?php echo e($vision->desc_ar); ?></textarea>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title "><?php echo app('translator')->get('translation.additional_data'); ?></h4>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sequence" class="form-label"><?php echo app('translator')->get('translation.sequence'); ?></label>
                        <input type="number" class="form-control" id="sequence" name="sequence" value="<?php echo e($mission->sequence); ?>" autofocus placeholder="<?php echo app('translator')->get('translation.enter_sequence'); ?>">
                    </div>

                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.create'); ?></button>
            </div>
        </form>       
    </div>
</div>
<!-- end row -->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('build/js/missions-and-visions/update-mission-and-vision.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/missions-and-visions/update-mission-and-vision.blade.php ENDPATH**/ ?>