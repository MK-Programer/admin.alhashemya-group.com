@extends('layouts.master')

@section('title') @lang('translation.update_user') - @lang('translation.id') {{ $user->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.users') @endslot
@slot('title') @lang('translation.update_user') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="update_user">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" value="{{ $userId }}">

                    <div class="mb-3">
                        <label for="id" class="form-label">@lang('translation.id')</label>
                        <input type="id" class="form-control" value="{{ $user->id }}" id="id" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('translation.name')</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" id="name" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('translation.email')</label>
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="groups" class="form-label">@lang('translation.groups')</label>
                        <select class="form-control" id="group" name="group[]" multiple>
                            @foreach($groups as $group)
                                <option 
                                    value="{{ $group->id }}"
                                    @if(in_array($group->id, $userGroupsId)) selected @endif
                                    >
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
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
<script src="{{ asset('build/js/select-multiple.js') }}"></script>
<script src="{{ asset('build/js/users/update-user.js') }}"></script>

@endsection