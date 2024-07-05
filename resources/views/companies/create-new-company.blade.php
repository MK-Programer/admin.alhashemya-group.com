@extends('layouts.master')

@section('title') @lang('translation.create_new_company') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.company') @endslot
@slot('title') @lang('translation.create_new_company') @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" id="update_company" data-action="{{ route('saveCreatedCompany') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">@lang('translation.phone')</label>
                        <input type="number" class="form-control" id="phone" name="phone" autofocus placeholder="@lang('translation.enter_phone')">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('translation.email')</label>
                        <input type="email" class="form-control" id="email" name="email" autofocus placeholder="@lang('translation.enter_email')">
                    </div>
                    <div class="mb-3">
                        <label for="fb_link" class="form-label">@lang('translation.fb_link')</label>
                        <input type="text" class="form-control" id="fb_link" name="fb_link" autofocus placeholder="@lang('translation.enter_fb_link')">
                    </div>
                    <div class="mb-3">
                        <label for="other_link" class="form-label">@lang('translation.other_link')</label>
                        <input type="text" class="form-control" id="other_link" name="other_link" autofocus placeholder="@lang('translation.enter_other_link')">
                    </div>

                    <div class="mb-3">
                        <label for="formFile">@lang('translation.picture')</label>
                        <input class="form-control" type="file" id="formFile" onChange="mainThamUrl(this)" name="picture">
                        <img class="mt-2" src="" id="mainThmb" alt="">
                    </div>

                    <div>
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.create')</button>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('script')


<script src="{{ asset('build/js/companies/create-new-company.js') }}"></script>

@endsection
