@extends('layouts.master')

@section('title') @lang('translation.profile') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.dashboard') @endslot
@slot('title') @lang('translation.profile') @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-user-profile">
            @csrf

            <div class="mb-3">
                <div class="text-start mt-2">
                    <img src="{{ asset($authUser->avatar) }}" alt="" class="rounded-circle avatar-lg" id="profile-image">
                </div>
                <label for="avatar">@lang('translation.profile_picture')</label>
                <div class="input-group">
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" autofocus>
                    <label class="input-group-text" for="avatar">@lang('translation.upload')</label>
                </div>
                
                <div class="text-danger" role="alert" id="avatar-error" data-ajax-feedback="avatar"></div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">@lang('translation.name')</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $authUser->name }}" id="name" name="name" autofocus placeholder="@lang('translation.enter_name')">
                <div class="text-danger" id="name-error" data-ajax-feedback="name"></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">@lang('translation.email')</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $authUser->email }}" name="email" placeholder="@lang('translation.enter_email')" autofocus>
                <div class="text-danger" id="email-error" data-ajax-feedback="email"></div>
            </div>

            

            <div class="mt-3 d-grid">
                <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit">@lang('translation.update')</button>
            </div>
        </form>

        <form class="form-horizontal mt-4" method="POST" id="update-password">
            @csrf
            <div class="mb-3">
                <label for="current-password" class="form-label">@lang('translation.current_password')</label>
                <input type="password" class="form-control @error('current-password') is-invalid @enderror" id="current-password" name="current-password" autofocus placeholder="@lang('translation.enter_current_password')">
                <div class="text-danger" id="current-password-error" data-ajax-feedback="current-password"></div>
            </div>

            <div class="mb-3">
                <label for="new-password" class="form-label">@lang('translation.new_password')</label>
                <input type="password" class="form-control @error('new-password') is-invalid @enderror" id="new-password" name="new-password" autofocus placeholder="@lang('translation.enter_new_password')">
                <div class="text-danger" id="new-password-error" data-ajax-feedback="new-password"></div>
            </div>

            <div class="mb-3">
                <label for="confirm-new-password" class="form-label">@lang('translation.confirm_new_password')</label>
                <input type="password" class="form-control @error('confirm-new-password') is-invalid @enderror" id="confirm-new-password" name="confirm-new-password" autofocus placeholder="@lang('translation.enter_confirm_new_password')">
                <div class="text-danger" id="confirm-new-password-error" data-ajax-feedback="confirm-new-password"></div>
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

    function resetErrors(){
        $('#avatar-error').text('');
        $('#name-error').text('');
        $('#email-error').text('');

        $('#avatar-error').hide();
        $('#name-error').hide();
        $('#email-error').hide();

        $('#current-password-error').text('');
        $('#new-password-error').text('');
        $('#confirm-new-password-error').text('');

        $('#current-password-error').hide();
        $('#new-password-error').hide();
        $('#confirm-new-password-error').hide();
        
    }

    $('#update-user-profile').on('submit', function(event) {
        event.preventDefault();
        showLoading();
        resetErrors();

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
            error: function(response) {
                var msg = response  .responseJSON['message'];;
                hideLoading();
                setDanger(msg);
                // $('#emailError').text(response.responseJSON.errors.email);
                // $('#nameError').text(response.responseJSON.errors.name);
                // $('#dobError').text(response.responseJSON.errors.dob);
                // $('#avatarError').text(response.responseJSON.errors.avatar);
            }
        });
    });
</script>

@endsection