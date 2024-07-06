

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.create_new_home'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.home'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.create_new_home'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                

                <form enctype="multipart/form-data" id="update_home">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.title_en'); ?></label>
                        <input type="text" class="form-control" id="title_en" name="title_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_en'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label"><?php echo app('translator')->get('translation.title_ar'); ?></label>
                        <input type="text" class="form-control" id="title_ar" name="title_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_title_ar'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                        <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                        <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Add Your Picture Here</label>
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
    <script src="<?php echo e(asset('build/js/home/create-new-home.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/home/create-new-home.blade.php ENDPATH**/ ?>