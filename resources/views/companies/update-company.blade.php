@extends('layouts.master')

@section('title') @lang('translation.update_company') - @lang('translation.id') {{ $company->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.company') @endslot
@slot('title') @lang('translation.update_company') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_company">
                    @csrf
                    <input type="hidden" id="company_id" name="company_id" value="{{ $company->id }}">

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="{{ $company->logo }}">
                            <img src = "{{ asset($company->logo) }}" alt="#" class="rounded-circle avatar-lg" id="company_image">
                        </div>
                        <label for="picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" value="{{ $company->name_en }}" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" value="{{ $company->name_ar }}" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">@lang('translation.phone')</label>
                        <input type="text" class="form-control" value="{{ $company->phone }}" id="phone" name="phone" autofocus placeholder="@lang('translation.enter_phone')">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('translation.email')</label>
                        <input type="text" class="form-control" value="{{ $company->email }}" id="email" name="email" autofocus placeholder="@lang('translation.enter_email')">
                    </div>
                    <div class="mb-3">
                        <label for="fb_link" class="form-label">@lang('translation.fb_link')</label>
                        <input type="text" class="form-control" value="{{ $company->fb_link }}" id="fb_link" name="fb_link" autofocus placeholder="@lang('translation.enter_fb_link')">
                    </div>
                    <div class="mb-3">
                        <label for="other_link" class="form-label">@lang('translation.other_link')</label>
                        <input type="text" class="form-control" value="{{ $company->other_link }}" id="other_link" name="other_link" autofocus placeholder="@lang('translation.enter_other_link')">
                    </div>


                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $company->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $company->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
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

<script src="{{ asset('build/js/companies/update-company.js') }}"></script>

@endsection
