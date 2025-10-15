<?php
    if ($type == 'partners'){
        $title = __('translation.partners');
        $createTxt = __('translation.create_new_partner'); 
    }else if($type == 'clients'){
        $title = __('translation.clients');
        $createTxt = __('translation.create_new_client');
    }
?>



<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

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
            <?php echo e($title); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-0 mb-3">
                        <a href="<?php echo e(route('showCreatePartnerOrClient', ['type' => $type])); ?>" id="create_partner_or_client" class="btn btn-primary"><?php echo e($createTxt); ?></a>
                    </div>
                    <table id="partners_or_clients_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('translation.id'); ?></th>
                                <th><?php echo app('translator')->get('translation.picture'); ?></th>
                                <th><?php echo app('translator')->get('translation.name_en'); ?></th>
                                <th><?php echo app('translator')->get('translation.name_ar'); ?></th>
                                <th><?php echo app('translator')->get('translation.sequence'); ?></th>
                                <th><?php echo app('translator')->get('translation.is_active'); ?></th>
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
        //lang
        var updateText = '<?php echo app('translator')->get('translation.update'); ?>';
        var yesText = '<?php echo app('translator')->get('translation.yes'); ?>';
        var noText = '<?php echo app('translator')->get('translation.no'); ?>';

        var type = '<?php echo e($type); ?>';
        
    </script>
    
    <script src="<?php echo e(asset('build/js/partners-or-clients/all-partners-or-clients.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/partners-or-clients/all-partners-or-clients.blade.php ENDPATH**/ ?>