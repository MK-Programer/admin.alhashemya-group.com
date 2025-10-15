

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.profile'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.dashboard'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.profile'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_user_profile">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" value="<?php echo e($authUser->avatar); ?>" id="user_db_picture" name="user_db_picture">
                            <img src="<?php echo e(asset($authUser->avatar)); ?>" alt="#" class="rounded-circle avatar-lg" id="profile_image">
                        </div>
                        <label for="avatar"><?php echo app('translator')->get('translation.profile_picture'); ?></label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="avatar" name="avatar" autofocus>
                            <label class="input-group-text" for="avatar"><?php echo app('translator')->get('translation.upload'); ?></label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label"><?php echo app('translator')->get('translation.name'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($authUser->name); ?>" id="name" name="name" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><?php echo app('translator')->get('translation.email'); ?></label>
                        <input type="email" class="form-control" id="email" value="<?php echo e($authUser->email); ?>" name="email" placeholder="<?php echo app('translator')->get('translation.enter_email'); ?>" autofocus>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
                    </div>
                </form>

                <form class="form-horizontal mt-4" id="update_user_password">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="current_password" class="form-label"><?php echo app('translator')->get('translation.current_password'); ?></label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autofocus placeholder="<?php echo app('translator')->get('translation.enter_current_password'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label"><?php echo app('translator')->get('translation.new_password'); ?></label>
                        <input type="password" class="form-control" id="new_password" name="new_password" autofocus placeholder="<?php echo app('translator')->get('translation.enter_new_password'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label"><?php echo app('translator')->get('translation.confirm_new_password'); ?></label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" autofocus placeholder="<?php echo app('translator')->get('translation.enter_confirm_new_password'); ?>">
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

<script src="<?php echo e(asset('build/js/user/profile.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/user/profile.blade.php ENDPATH**/ ?>