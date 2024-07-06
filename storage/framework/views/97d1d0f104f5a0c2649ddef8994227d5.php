

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.create_new_mission_and_vision'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.missions_and_visions'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.create_new_mission_and_vision'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form class="form-horizontal" enctype="multipart/form-data" id="new_mission_vision_form">
            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title "><?php echo app('translator')->get('translation.mission'); ?></h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <img alt="#" class="rounded-circle avatar-lg" id="mission_image">
                        </div>
                        <label for="mission_picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="mission_picture" name="mission_picture" autofocus>
                            <label class="input-group-text" for="mission_picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_en" class="form-label"><?php echo app('translator')->get('translation.title_en'); ?></label>
                        <input type="text" class="form-control" id="mission_title_en" name="mission_title_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_ar" class="form-label"><?php echo app('translator')->get('translation.title_ar'); ?></label>
                        <input type="text" class="form-control" id="mission_title_ar" name="mission_title_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                        <textarea class="form-control" id="mission_description_en" name="mission_description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                        <textarea class="form-control" id="mission_description_ar" name="mission_description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"></textarea>
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
                            <img alt="#" class="rounded-circle avatar-lg" id="vision_image">
                        </div>
                        <label for="vision_picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="vision_picture" name="vision_picture" autofocus>
                            <label class="input-group-text" for="vision_picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_en" class="form-label"><?php echo app('translator')->get('translation.title_en'); ?></label>
                        <input type="text" class="form-control" id="vision_title_en" name="vision_title_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_ar" class="form-label"><?php echo app('translator')->get('translation.title_ar'); ?></label>
                        <input type="text" class="form-control" id="vision_title_ar" name="vision_title_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                        <textarea class="form-control" id="vision_description_en" name="vision_description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                        <textarea class="form-control" id="vision_description_ar" name="vision_description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"></textarea>
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

<script src="<?php echo e(asset('build/js/missions-and-visions/create-new-mission-and-vision.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/missions-and-visions/create-new-mission-and-vision.blade.php ENDPATH**/ ?>