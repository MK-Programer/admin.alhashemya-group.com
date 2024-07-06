<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.create_new_product'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.products'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.create_new_product'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>


<form method="POST"  enctype="multipart/form-data" id="new_product"  data-action="<?php echo e(route('saveCreatedProduct')); ?>">
<?php echo csrf_field(); ?>
<div class="row">
        <div class="col-12">
            <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card">
                <div class="card-body">


                        <div class="mb-3">
                            <label for="product_category" class="form-label"><?php echo app('translator')->get('translation.product_category'); ?></label>
                            <select class="form-control" id="product_category" name="category_id">
                                <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" ><?php echo e($category->name_en); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                        </div>

                        <div class="mb-3">
                            <div class="text-start mt-2">
                                <img alt="#" class="rounded-circle avatar-lg" id="product_image">
                            </div>
                            <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="picture" name="picture" autofocus>
                                <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label"><?php echo app('translator')->get('translation.product_code'); ?></label>
                            <input type="text" class="form-control" id="code" name="code" autofocus placeholder="<?php echo app('translator')->get('translation.enter_product_code'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                            <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                            <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                            <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"></textarea>
                        </div>



                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-model-input" class="form-label"><?php echo app('translator')->get('translation.model'); ?></label>
                                    <input type="text" class="form-control" id="formrow-model-input" name="model" placeholder="<?php echo app('translator')->get('translation.enter_model'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-voltage-input" class="form-label"><?php echo app('translator')->get('translation.voltage'); ?></label>
                                    <input type="text" class="form-control" id="formrow-voltage-input" name="voltage" placeholder="<?php echo app('translator')->get('translation.enter_voltage'); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-capacity-input" class="form-label"><?php echo app('translator')->get('translation.capacity'); ?></label>
                                    <input type="text" class="form-control" id="formrow-capacity-input" name="capacity" placeholder="<?php echo app('translator')->get('translation.enter_capacity'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-length-input" class="form-label"><?php echo app('translator')->get('translation.length'); ?></label>
                                    <input type="text" class="form-control" id="formrow-length-input" name="length" placeholder="<?php echo app('translator')->get('translation.enter_length'); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-width-input" class="form-label"><?php echo app('translator')->get('translation.width'); ?></label>
                                    <input type="text" class="form-control" id="formrow-width-input"  name="width" placeholder="<?php echo app('translator')->get('translation.enter_width'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-height-input" class="form-label"><?php echo app('translator')->get('translation.height'); ?></label>
                                    <input type="text" class="form-control" id="formrow-height-input" name="height" placeholder="<?php echo app('translator')->get('translation.enter_height'); ?>">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-totalheight-input" class="form-label"><?php echo app('translator')->get('translation.total_height'); ?></label>
                                    <input type="text" class="form-control" id="formrow-totalheight-input" name="total_height" placeholder="<?php echo app('translator')->get('translation.enter_total_height'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-greossweight-input" class="form-label"><?php echo app('translator')->get('translation.gross_weight'); ?></label>
                                    <input type="text" class="form-control" id="formrow-greossweight-input" name="gross_weight" placeholder="<?php echo app('translator')->get('translation.enter_gross_weight'); ?>">
                                </div>
                            </div>
                        </div>


                </div>
            </div>

        </div>
    </div>
<!-- end row -->


<div class="row">
    <!-- Applications Repeater -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body repeater">
                <h4 class="card-title mb-4"><?php echo app('translator')->get('translation.applications'); ?></h4>
                <div id="applicationsRepeater">
                    <div data-repeater-list="applications">
                        <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-10">
                                <input type="text" name="application" placeholder="<?php echo app('translator')->get('translation.enter_application'); ?>" class="form-control" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid">
                                    <input data-repeater-delete type="button" class="btn btn-primary" value="<?php echo app('translator')->get('translation.delete'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="<?php echo app('translator')->get('translation.add'); ?>" />
                </div>
            </div>
        </div>
    </div>

    <!-- Features and Benefits Repeater -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?php echo app('translator')->get('translation.features_and_benefits'); ?></h4>
                <div id="featuresRepeater" class="repeater">
                    <div data-repeater-list="features">
                        <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-10">
                                <input type="text" name="feature" placeholder="<?php echo app('translator')->get('translation.enter_features_or_benefits'); ?>" class="form-control" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid">
                                    <input data-repeater-delete type="button" class="btn btn-primary" value="<?php echo app('translator')->get('translation.delete'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="<?php echo app('translator')->get('translation.add'); ?>" />
                </div>
            </div>
        </div>
    </div>
</div>





<div class="mt-3" style="text-align: center">
    <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.create'); ?></button>
</div>

</form>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('build/libs/jquery.repeater/jquery.repeater.min.js')); ?>"></script>

<script src="<?php echo e(asset('/build/js/pages/form-repeater.int.js')); ?>"></script>

<script src="<?php echo e(asset('build/js/products/create-new-product.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/products/create-new-product.blade.php ENDPATH**/ ?>