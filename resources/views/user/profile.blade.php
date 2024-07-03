@extends('layouts.master')

@section('title') @lang('translation.profile') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.dashboard') @endslot
@slot('title') @lang('translation.profile') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_user_profile">
                    @csrf

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" value="{{ $authUser->avatar }}" id="user_db_picture" name="user_db_picture">
                            <img src="{{ asset($authUser->avatar) }}" alt="#" class="rounded-circle avatar-lg" id="profile_image">
                        </div>
                        <label for="avatar">@lang('translation.profile_picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="avatar" name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('translation.name')</label>
                        <input type="text" class="form-control" value="{{ $authUser->name }}" id="name" name="name" autofocus placeholder="@lang('translation.enter_name')">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('translation.email')</label>
                        <input type="email" class="form-control" id="email" value="{{ $authUser->email }}" name="email" placeholder="@lang('translation.enter_email')" autofocus>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.update')</button>
                    </div>
                </form>

                <form class="form-horizontal mt-4" id="update_user_password">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">@lang('translation.current_password')</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autofocus placeholder="@lang('translation.enter_current_password')">
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">@lang('translation.new_password')</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" autofocus placeholder="@lang('translation.enter_new_password')">
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">@lang('translation.confirm_new_password')</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" autofocus placeholder="@lang('translation.enter_confirm_new_password')">
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

<script src="{{ asset('build/js/user/profile.js') }}"></script>

@endsection