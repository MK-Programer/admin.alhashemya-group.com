

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.services'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo app('translator')->get('translation.dashboard'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('translation.services'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div style="margin-top: 20px">
                <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="services_form" class="form-horizontal">
                        <?php echo csrf_field(); ?>
                        <table id="services_table" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Picture</th>
                                    <th>Title En</th>
                                    <th>Title Ar</th>
                                    <th>Description En</th>
                                    <th>Description Ar</th>
                                    <th>Sequence</th>
                                </tr>
                            </thead>

                            <tbody id="copy-container">
                                <tr style="display:none" id="div-copy">
                                    <td>
                                        <input type="checkbox" name="chk[]"/>
                                        <input type="hidden" name="id[]"/>
                                    </td>
                                    
                                    <td>
                                        
                                        <img alt="#" class="rounded-circle avatar-lg">
                                        
                                        <input type="hidden" name="hidden_picture[]"> 
                                        
                                        <input type="file" class="form-control" name="new_picture[]">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="title_en[]">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="title_ar[]">
                                    </td>
                                    
                                    <td>
                                        <textarea class="form-control" name="description_en[]" cols="50"></textarea>
                                    </td>

                                    <td>
                                        <textarea class="form-control" name="description_ar[]" cols="50"></textarea>
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" name="sequence[]">
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                        <input type="button" id="add" class="btn btn-success" onclick="addRow()" value="<?php echo app('translator')->get('translation.add_row'); ?>">
                        <input type="button" id="remove" style="display:none" class="btn btn-danger" onclick="deleteRow()" value="<?php echo app('translator')->get('translation.delete_rows'); ?>">          
                        <div class="mt-3">
                            <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/js/lang/lang.js')); ?>"></script>
    
    
    <script src="<?php echo e(URL::asset('build/js/unique-id.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/services/services.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var services = <?php echo $services; ?>;
            createFetchedServices(services);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/services/services.blade.php ENDPATH**/ ?>