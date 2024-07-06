

<?php $__env->startSection('title'); ?> Home <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Admin <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> orders <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchTableList"
                                    placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                        id="order-list">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Sender Name </th>
                                <th class="align-middle">Sender Email</th>
                                <th class="align-middle">Product Name</th>
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Subject</th>
                                <th class="align-middle">Body</th>
                                <th class="align-middle">status</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input class="form-check-input font-size-15" type="checkbox" id="check"></td>
                                    <td><?php echo e($order->sender_name); ?></td>
                                    <td><?php echo e($order->sender_email); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo e($order->subject); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#orderdetailsModal_<?php echo e($order->id); ?>">
                                            View Body
                                        </button>
                                    </td>
                                    <td></td>
                                    <td style="text-align: center" >
                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- end table responsive -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Modal -->
        <div class="modal fade" id="orderdetailsModal_<?php echo e($order->id); ?>" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=orderdetailsModalLabel">Body</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word; max-height: auto; overflow-y: auto;">
                        <p class="mb-2">
                            <?php echo e($order->body); ?>

                        </p>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- apexcharts -->
<script src="<?php echo e(URL::asset('/build/libs/apexcharts/apexcharts.min.js')); ?>"></script>

<!-- dashboard init -->
<script src="<?php echo e(URL::asset('build/js/pages/dashboard.init.js')); ?>"></script>

<script type="text/javascript">
        $('#mainThmb').hide();

	function mainThamUrl(input){
        $('#mainThmb').show();
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmb').attr('src',e.target.result).width(100).height(100);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/admin/orders.blade.php ENDPATH**/ ?>