@extends('layouts.master')

@section('title') @lang('translation.create_new_user') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.users') @endslot
@slot('title') @lang('translation.create_new_user') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="new_user">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar">@lang('translation.profile_picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="avatar" name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('translation.name')</label>
                        <input type="text" class="form-control" id="name" name="name" autofocus placeholder="@lang('translation.enter_name')">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('translation.email')</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="@lang('translation.enter_email')" autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('translation.password')</label>
                        <input type="password" class="form-control" id="password" name="password" autofocus placeholder="@lang('translation.enter_password')">
                    </div>

                    <div class="mb-3">
                        <label for="groups" class="form-label">@lang('translation.groups')</label>
                        <select class="form-control" id="group" name="group[]" multiple>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
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
<script src="{{ asset('build/js/select-multiple.js') }}"></script>
<script src="{{ asset('build/js/users/create-new-user.js') }}"></script>
@endsection