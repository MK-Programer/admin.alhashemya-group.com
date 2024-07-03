

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.message_details'); ?>
    - 
    <?php echo app('translator')->get('translation.id'); ?> <?php echo e($message->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.messages'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.message_details'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title "><?php echo app('translator')->get('translation.sender_details'); ?></h4>
                </div>
                <table id="sender_details_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('translation.id'); ?></th>
                            <th><?php echo app('translator')->get('translation.sender_name'); ?></th>
                            <th><?php echo app('translator')->get('translation.sender_email'); ?></th>
                            <th><?php echo app('translator')->get('translation.phone_number'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($message->id); ?></td>
                            <td><?php echo e($message->sender_name); ?></td>
                            <td><?php echo e($message->sender_email); ?></td>
                            <td><?php echo e($message->phone_number); ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title "><?php echo app('translator')->get('translation.message'); ?></h4>
                </div>
                <table id="message_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('translation.subject'); ?></th>
                            <th><?php echo app('translator')->get('translation.body'); ?></th>
                            <th><?php echo app('translator')->get('translation.is_reviewed'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($message->subject); ?></td>
                            <th><?php echo e($message->body); ?></th>
                            <td><?php if($message->is_checked == 1): ?> <?php echo app('translator')->get('translation.yes'); ?> <?php else: ?>  <?php echo app('translator')->get('translation.no'); ?> <?php endif; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
        
        <?php if($product): ?>
            <div class="card">
                <div class="card-body">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title "><?php echo app('translator')->get('translation.product_details'); ?></h4>
                    </div>
                    <table id="product_details_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('translation.id'); ?></th>
                                <th><?php echo app('translator')->get('translation.product_name_en'); ?></th>
                                <th><?php echo app('translator')->get('translation.product_name_ar'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo e($product->product_code); ?></td>
                                <td><?php echo e($product->name_en); ?></td>
                                <td><?php echo e($product->name_ar); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
        <?php endif; ?>
    </div>
</div>
<!-- end row -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/messages/read-message.blade.php ENDPATH**/ ?>