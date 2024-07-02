

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.mission_and_vision_details'); ?>
    - 
    <?php echo app('translator')->get('translation.id'); ?> <?php echo e($mission->id.' - '.$vision->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.missions_and_visions'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.mission_and_vision_details'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="card-header card-header-primary">
                    <h4 class="card-title "><?php echo app('translator')->get('translation.mission'); ?></h4>
                </div>
                <table id="mission_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('translation.id'); ?></th>
                            <th><?php echo app('translator')->get('translation.mission_title_en'); ?></th>
                            <th><?php echo app('translator')->get('translation.mission_title_ar'); ?></th>
                            <th><?php echo app('translator')->get('translation.mission_description_en'); ?></th>
                            <th><?php echo app('translator')->get('translation.mission_description_ar'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($mission->id); ?></td>
                            <td><?php echo e($mission->title_en); ?></td>
                            <td><?php echo e($mission->title_ar); ?></td>
                            <td><?php echo e($mission->desc_en); ?></td>
                            <td><?php echo e($mission->desc_ar); ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>    
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title "><?php echo app('translator')->get('translation.vision'); ?></h4>
                </div>
                <table id="vision_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('translation.id'); ?></th>
                            <th><?php echo app('translator')->get('translation.vision_title_en'); ?></th>
                            <th><?php echo app('translator')->get('translation.vision_title_ar'); ?></th>
                            <th><?php echo app('translator')->get('translation.vision_description_en'); ?></th>
                            <th><?php echo app('translator')->get('translation.vision_description_ar'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($vision->id); ?></td>
                            <td><?php echo e($vision->title_en); ?></td>
                            <td><?php echo e($vision->title_ar); ?></td>
                            <td><?php echo e($vision->desc_en); ?></td>
                            <td><?php echo e($vision->desc_ar); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
        
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title "><?php echo app('translator')->get('translation.additional_data'); ?></h4>
                </div>
                <table id="vision_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('translation.is_active'); ?></th>
                            <th><?php echo app('translator')->get('translation.sequence'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php if($mission->is_active == 1): ?> <?php echo app('translator')->get('translation.yes'); ?> <?php else: ?> <?php echo app('translator')->get('translation.no'); ?> <?php endif; ?></td>
                            <td><?php echo e($mission->sequence); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>
<!-- end row -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/missions-and-visions/read-mission-and-vision.blade.php ENDPATH**/ ?>