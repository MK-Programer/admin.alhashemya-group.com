

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_group'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($group->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.groups'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_group'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="update_group">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="group_id" name="group_id" value="<?php echo e($groupId); ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label"><?php echo app('translator')->get('translation.name'); ?></label>
                        <input type="text" class="form-control" value="<?php echo e($group->name); ?>" id="name" name="name" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="menu" class="form-label"><?php echo app('translator')->get('translation.menu'); ?></label>
                        <select class="form-control" id="menu" name="menu[]" multiple>
                            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option 
                                    value="<?php echo e($item->id); ?>"
                                    <?php if(in_array($item->id, $selectedMenusIds)): ?> selected <?php endif; ?>
                                >
                                    <?php echo e($item->name); ?>

                                 </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                            <option value="1" <?php echo e($group->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                            <option value="0" <?php echo e($group->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
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

<script src="<?php echo e(asset('build/js/select-multiple.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/groups/update-group.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/groups/update-group.blade.php ENDPATH**/ ?>