

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.messages'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- DataTables -->
    <link href="<?php echo e(asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo e(asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?php echo e(asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo app('translator')->get('translation.dashboard'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('translation.messages'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card">
                <div class="card-body">
                    <form style="display: none" id="messages_review_status_form">
                        <?php echo csrf_field(); ?>
                        <div class="input-group mb-3">
                            <select class="form-control-sm" id="is_reviewed" name="is_reviewed">
                                <option value="1"><?php echo app('translator')->get('translation.yes'); ?></option>
                                <option value="0"><?php echo app('translator')->get('translation.no'); ?></option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><?php echo app('translator')->get('translation.change_to_reviewed'); ?></button>
                            </div>
                        </div>
                    </form>
                    <table id="messages_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo app('translator')->get('translation.id'); ?></th>
                                <th><?php echo app('translator')->get('translation.sender_name'); ?></th>
                                <th><?php echo app('translator')->get('translation.product_id'); ?></th>
                                <th><?php echo app('translator')->get('translation.subject'); ?></th>
                                <th><?php echo app('translator')->get('translation.is_reviewed'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- Required datatable js -->
    <script src="<?php echo e(asset('build/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
   
    <!-- Responsive examples -->
    <script src="<?php echo e(asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>
    
    
    <script>
        var detailsText = '<?php echo app('translator')->get('translation.details'); ?>';
        var yesText = '<?php echo app('translator')->get('translation.yes'); ?>';
        var noText = '<?php echo app('translator')->get('translation.no'); ?>';
    </script>
    
    <script src="<?php echo e(asset('build/js/messages/all-messages.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/messages/all-messages.blade.php ENDPATH**/ ?>