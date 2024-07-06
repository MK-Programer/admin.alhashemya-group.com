<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.update_product'); ?> - <?php echo app('translator')->get('translation.id'); ?> <?php echo e($product->id); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.products'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.update_product'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<form method="post" enctype="multipart/form-data" action="<?php echo e(route('saveUpdatedProduct')); ?>" >
    <?php echo csrf_field(); ?>
    <input type="hidden" id="product_id" name="product_id" value="<?php echo e($product->product_id); ?>">

    <div class="row">
            <div class="col-12">
                <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-body">


                            <div class="mb-3">
                                <label for="product_category" class="form-label"><?php echo app('translator')->get('translation.product_category'); ?></label>
                                <select class="form-control" id="product_category" name="category_id">
                                    <option disabled selected><?php echo app('translator')->get('translation.enter_category'); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $product->category_id ? 'selected' : ''); ?> ><?php echo e($category->name_en); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>

                            <div class="mb-3">
                                <div class="text-start mt-2">
                                    <input type="hidden" id="db_picture" name="db_picture" value="<?php echo e($product->picture); ?>">
                                    <img src = "<?php echo e(asset($product->picture)); ?>" alt="#" class="rounded-circle avatar-lg" id="product_image">
                                </div>
                                <label for="picture"><?php echo app('translator')->get('translation.picture'); ?></label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="picture" name="picture" autofocus>
                                    <label class="input-group-text" for="picture"><?php echo app('translator')->get('translation.upload'); ?></label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label"><?php echo app('translator')->get('translation.product_code'); ?></label>
                                <input type="text" class="form-control" id="code" name="code" autofocus placeholder="<?php echo app('translator')->get('translation.enter_product_code'); ?>" value="<?php echo e($product->product_code); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="title_en" class="form-label"><?php echo app('translator')->get('translation.name_en'); ?></label>
                                <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_en'); ?>" value="<?php echo e($product->name_en); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="name_ar" class="form-label"><?php echo app('translator')->get('translation.name_ar'); ?></label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name_ar'); ?>" value="<?php echo e($product->name_ar); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="description_en" class="form-label"><?php echo app('translator')->get('translation.description_en'); ?></label>
                                <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_en'); ?>"><?php echo e($product->desc_en); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="description_ar" class="form-label"><?php echo app('translator')->get('translation.description_ar'); ?></label>
                                <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="<?php echo app('translator')->get('translation.enter_description_ar'); ?>"><?php echo e($product->desc_ar); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="is_active" class="form-label"><?php echo app('translator')->get('translation.is_active'); ?></label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option disabled selected><?php echo app('translator')->get('translation.enter_status'); ?></option>
                                    <option value="1" <?php echo e($product->is_active == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.yes'); ?></option>
                                    <option value="0" <?php echo e($product->is_active == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('translation.no'); ?></option>
                                </select>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-model-input" class="form-label"><?php echo app('translator')->get('translation.model'); ?></label>
                                        <input type="text" class="form-control" id="formrow-model-input" name="model" placeholder="<?php echo app('translator')->get('translation.enter_model'); ?>" value="<?php echo e($product->model); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-voltage-input" class="form-label"><?php echo app('translator')->get('translation.voltage'); ?></label>
                                        <input type="text" class="form-control" id="formrow-voltage-input" name="voltage" placeholder="<?php echo app('translator')->get('translation.enter_voltage'); ?>" value="<?php echo e($product->voltage); ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-capacity-input" class="form-label"><?php echo app('translator')->get('translation.capacity'); ?></label>
                                        <input type="text" class="form-control" id="formrow-capacity-input" name="capacity" placeholder="<?php echo app('translator')->get('translation.enter_capacity'); ?>" value="<?php echo e($product->capacity); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-length-input" class="form-label"><?php echo app('translator')->get('translation.length'); ?></label>
                                        <input type="text" class="form-control" id="formrow-length-input" name="length" placeholder="<?php echo app('translator')->get('translation.enter_length'); ?>" value="<?php echo e($product->length); ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-width-input" class="form-label"><?php echo app('translator')->get('translation.width'); ?></label>
                                        <input type="text" class="form-control" id="formrow-width-input"  name="width" placeholder="<?php echo app('translator')->get('translation.enter_width'); ?>" value="<?php echo e($product->width); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-height-input" class="form-label"><?php echo app('translator')->get('translation.height'); ?></label>
                                        <input type="text" class="form-control" id="formrow-height-input" name="height" placeholder="<?php echo app('translator')->get('translation.enter_height'); ?>" value="<?php echo e($product->height); ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-totalheight-input" class="form-label"><?php echo app('translator')->get('translation.total_height'); ?></label>
                                        <input type="text" class="form-control" id="formrow-totalheight-input" name="total_height" placeholder="<?php echo app('translator')->get('translation.enter_total_height'); ?>" value="<?php echo e($product->total_height); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-greossweight-input" class="form-label"><?php echo app('translator')->get('translation.gross_weight'); ?></label>
                                        <input type="text" class="form-control" id="formrow-greossweight-input" name="gross_weight" placeholder="<?php echo app('translator')->get('translation.enter_gross_weight'); ?>" value="<?php echo e($product->gross_weight); ?>">
                                    </div>
                                </div>
                            </div>


                    </div>
                </div>

            </div>
        </div>
    <!-- end row -->

    <?php
        $arr=[];
        $arr2=[];
    ?>

<div class="row">
    <!-- Applications Repeater -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body" >
                <h4 class="card-title mb-4"><?php echo app('translator')->get('translation.applications'); ?></h4>
                    <?php $__currentLoopData = $product->infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item->type == 'application'): ?>
                                    <div data-repeater-item class="row">
                                        <div class="mb-3 col-lg-10">
                                            <input type="text" name="old_application" placeholder="<?php echo app('translator')->get('translation.enter_application'); ?>" value="<?php echo e($item->info); ?>" class="form-control" />
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="d-grid">
                                                <input data-repeater-delete type="button" class="btn btn-primary" value="<?php echo app('translator')->get('translation.delete'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

                <?php $__currentLoopData = $product->infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->type == 'feature'): ?>

                        <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-10">
                                <input type="text" name="old_feature_<?php echo e($key); ?>" value="<?php echo e($item->info); ?>" placeholder="<?php echo app('translator')->get('translation.enter_features_or_benefits'); ?>" class="form-control" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid">
                                    <input data-repeater-delete type="button" class="btn btn-primary" value="<?php echo app('translator')->get('translation.delete'); ?>" />
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div id="featuresRepeater" >
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
        <button class="btn btn-primary waves-effect waves-light" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
    </div>
</form>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('build/libs/jquery.repeater/jquery.repeater.min.js')); ?>"></script>

<script src="<?php echo e(asset('/build/js/pages/form-repeater.int.js')); ?>"></script>

<script src="<?php echo e(asset('build/js/products/update-product1.js')); ?>"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\elhashemya_group\resources\views/products/update-product.blade.php ENDPATH**/ ?>