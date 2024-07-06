@extends('layouts.master')

@section('title') @lang('translation.create_new_product') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.products') @endslot
@slot('title') @lang('translation.create_new_product') @endslot
@endcomponent


<form method="POST"  enctype="multipart/form-data" id="new_product"  data-action="{{ route('saveCreatedProduct') }}">
@csrf
<div class="row">
        <div class="col-12">
            @include('layouts.utils.loading')
            @include('layouts.utils.success-danger')
            <div class="card">
                <div class="card-body">


                        <div class="mb-3">
                            <label for="product_category" class="form-label">@lang('translation.product_category')</label>
                            <select class="form-control" id="product_category" name="category_id">
                                <option disabled selected>@lang('translation.enter_status')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name_en }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3">
                            <div class="text-start mt-2">
                                <img alt="#" class="rounded-circle avatar-lg" id="product_image">
                            </div>
                            <label for="picture">@lang('translation.picture')</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="picture" name="picture" autofocus>
                                <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">@lang('translation.product_code')</label>
                            <input type="text" class="form-control" id="code" name="code" autofocus placeholder="@lang('translation.enter_product_code')">
                        </div>

                        <div class="mb-3">
                            <label for="title_en" class="form-label">@lang('translation.name_en')</label>
                            <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                        </div>

                        <div class="mb-3">
                            <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                        </div>

                        <div class="mb-3">
                            <label for="description_en" class="form-label">@lang('translation.description_en')</label>
                            <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description_ar" class="form-label">@lang('translation.description_ar')</label>
                            <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')"></textarea>
                        </div>



                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-model-input" class="form-label">@lang('translation.model')</label>
                                    <input type="text" class="form-control" id="formrow-model-input" name="model" placeholder="@lang('translation.enter_model')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-voltage-input" class="form-label">@lang('translation.voltage')</label>
                                    <input type="text" class="form-control" id="formrow-voltage-input" name="voltage" placeholder="@lang('translation.enter_voltage')">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-capacity-input" class="form-label">@lang('translation.capacity')</label>
                                    <input type="text" class="form-control" id="formrow-capacity-input" name="capacity" placeholder="@lang('translation.enter_capacity')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-length-input" class="form-label">@lang('translation.length')</label>
                                    <input type="text" class="form-control" id="formrow-length-input" name="length" placeholder="@lang('translation.enter_length')">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-width-input" class="form-label">@lang('translation.width')</label>
                                    <input type="text" class="form-control" id="formrow-width-input"  name="width" placeholder="@lang('translation.enter_width')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-height-input" class="form-label">@lang('translation.height')</label>
                                    <input type="text" class="form-control" id="formrow-height-input" name="height" placeholder="@lang('translation.enter_height')">
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-totalheight-input" class="form-label">@lang('translation.total_height')</label>
                                    <input type="text" class="form-control" id="formrow-totalheight-input" name="total_height" placeholder="@lang('translation.enter_total_height')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-greossweight-input" class="form-label">@lang('translation.gross_weight')</label>
                                    <input type="text" class="form-control" id="formrow-greossweight-input" name="gross_weight" placeholder="@lang('translation.enter_gross_weight')">
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
                <h4 class="card-title mb-4">@lang('translation.applications')</h4>
                <div id="applicationsRepeater">
                    <div data-repeater-list="applications">
                        <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-10">
                                <input type="text" name="application" placeholder="@lang('translation.enter_application')" class="form-control" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid">
                                    <input data-repeater-delete type="button" class="btn btn-primary" value="@lang('translation.delete')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="@lang('translation.add')" />
                </div>
            </div>
        </div>
    </div>

    <!-- Features and Benefits Repeater -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.features_and_benefits')</h4>
                <div id="featuresRepeater" class="repeater">
                    <div data-repeater-list="features">
                        <div data-repeater-item class="row">
                            <div class="mb-3 col-lg-10">
                                <input type="text" name="feature" placeholder="@lang('translation.enter_features_or_benefits')" class="form-control" />
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid">
                                    <input data-repeater-delete type="button" class="btn btn-primary" value="@lang('translation.delete')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="@lang('translation.add')" />
                </div>
            </div>
        </div>
    </div>
</div>





<div class="mt-3" style="text-align: center">
    <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.create')</button>
</div>

</form>


@endsection
@section('script')

<script src="{{ asset('build/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>

<script src="{{ asset('/build/js/pages/form-repeater.int.js') }}"></script>

<script src="{{ asset('build/js/products/create-new-product.js') }}"></script>

@endsection
