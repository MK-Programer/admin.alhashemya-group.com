@extends('layouts.master')

@section('title') @lang('translation.update_category') - @lang('translation.id') {{ $category->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.categories') @endslot
@slot('title') @lang('translation.update_category') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_category">
                    @csrf
                    <input type="hidden" id="category_id" name="category_id" value="{{ $categoryId }}">


                    <div class="mb-3">
                        <label for="name_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" value="{{ $category->name_en }}" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" value="{{ $category->name_ar }}" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>


                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $category->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $category->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.update')</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- end row -->


@endsection
@section('script')

<script src="{{ asset('build/js/categories/update-category.js') }}"></script>

@endsection
