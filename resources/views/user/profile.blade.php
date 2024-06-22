@extends('layouts.master')

@section('title') @lang('translation.profile') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.dashboard') @endslot
@slot('title') @lang('translation.profile') @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12 bg-white">
        @include('layouts.utils.loading')
        <div style="margin-top: 20px">
            @include('layouts.utils.success-danger')
        </div>
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-user-profile">
            @csrf

            <div class="mb-3">
                <div class="text-start mt-2">
                    <img src="{{ asset($authUser->avatar) }}" alt="" class="rounded-circle avatar-lg" id="profile-image">
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

            

            <div class="mt-3 d-grid">
                <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit">@lang('translation.update')</button>
            </div>
        </form>

        <form class="form-horizontal mt-4" method="POST" id="update-user-password">
            @csrf
            <div class="mb-3">
                <label for="current-password" class="form-label">@lang('translation.current_password')</label>
                <input type="password" class="form-control" id="current-password" name="current-password" autofocus placeholder="@lang('translation.enter_current_password')">
            </div>

            <div class="mb-3">
                <label for="new-password" class="form-label">@lang('translation.new_password')</label>
                <input type="password" class="form-control" id="new-password" name="new-password" autofocus placeholder="@lang('translation.enter_new_password')">
            </div>

            <div class="mb-3">
                <label for="new-password_confirmation" class="form-label">@lang('translation.confirm_new_password')</label>
                <input type="password" class="form-control" id="new-password_confirmation" name="new-password_confirmation" autofocus placeholder="@lang('translation.enter_confirm_new_password')">
             </div>

            <div class="mt-3 d-grid">
                <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit">@lang('translation.update')</button>
            </div>
        </form>
    </div>
</div>
<!-- end row -->


@endsection
@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('avatar');
        const profileImage = document.getElementById('profile-image');
        const avatarError = document.getElementById('avatar-error');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Clear any previous error messages
                avatarError.textContent = '';
                
                // Create a temporary URL for the selected file and update the image src
                const imageUrl = URL.createObjectURL(file);
                profileImage.src = imageUrl;

                // Revoke the object URL after the image is loaded
                profileImage.onload = function() {
                    URL.revokeObjectURL(imageUrl);
                };
            } 
            // else {
            //     console.log('No file selected');
            // }
        });
    });


    $('#update-user-profile').on('submit', function(event) {
        event.preventDefault();
        showLoading();
        hideAlert();

        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('updateUserProfile') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var msg = response['message'];

                hideLoading();
                setSuccess(msg);

                // Reload the page after 2 seconds (2000 milliseconds)
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                hideLoading();
                if (xhr.status === 422) {
                    
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    var errorsList = [];
                    // Example handling for email and name errors
                    
                    if (errors.hasOwnProperty('avatar')) {
                        errorsList = errorsList.concat(errors.avatar);
                    }
                    if (errors.hasOwnProperty('name')) {
                        errorsList = errorsList.concat(errors.name);
                    }
                    if (errors.hasOwnProperty('email')) {
                        errorsList = errorsList.concat(errors.email);
                    }
                    
                    setDanger(errorsList);
                } else {
                    // Server-side error caught in catch block
                    var msg = xhr.responseJSON.message;
                    setDanger(msg);
                }
            }
        });
    });

    $('#update-user-password').on('submit', function(event) {
        event.preventDefault();
        showLoading();
        hideAlert();

        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('updateUserPassword') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var msg = response['message'];

                hideLoading();
                setSuccess(msg);

                // Reload the page after 2 seconds (2000 milliseconds)
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                hideLoading();
                if (xhr.status === 422) {
                    
                    // Validation errors
                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    var errorsList = [];
                    // Example handling for email and name errors
                    
                    if (errors.hasOwnProperty('current-password')) {
                        errorsList = errorsList.concat(errors['current-password']);
                    }
                    if (errors.hasOwnProperty('new-password')) {
                        errorsList = errorsList.concat(errors['new-password']);
                    }
                    if (errors.hasOwnProperty('new-password_confirmation')) {
                        errorsList = errorsList.concat(errors['new-password_confirmation']);
                    }
                    
                    setDanger(errorsList);
                } else {
                    // Server-side error caught in catch block
                    var msg = xhr.responseJSON.message;
                    setDanger(msg);
                }
            }
        });
    });
</script>

@endsection