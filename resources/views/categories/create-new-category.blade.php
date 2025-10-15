@extends('layouts.master')

@section('title') @lang('translation.create_new_category') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.categories') @endslot
@slot('title') @lang('translation.create_new_category') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="new_category">
                    @csrf

                    <div class="mb-3">
                        <label for="name_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>


                    <div class="mt-3">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.create')</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- end row -->


@endsection
@section('script')

<script src="{{ asset('build/js/categories/create-new-category.js') }}"></script>

@endsection
