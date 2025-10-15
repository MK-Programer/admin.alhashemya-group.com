@extends('layouts.master')

@section('title') @lang('translation.about_us') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.about_us') @endslot
@slot('title') @lang('translation.create_new_about_us') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="new_about_us">
                    @csrf
                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <img alt="#" class="rounded-circle avatar-lg" id="about_us_image">
                        </div>
                        <label for="picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title_en" class="form-label">@lang('translation.title_en')</label>
                        <input type="text" class="form-control" id="title_en" name="title_en" autofocus placeholder="@lang('translation.enter_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label">@lang('translation.title_ar')</label>
                        <input type="text" class="form-control" id="title_ar" name="title_ar" autofocus placeholder="@lang('translation.enter_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label">@lang('translation.description_en')</label>
                        <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label">@lang('translation.description_ar')</label>
                        <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')"></textarea>
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

<script src="{{ asset('build/js/about-us/create-new-about-us.js') }}"></script>

@endsection
