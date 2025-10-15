@extends('layouts.master')

@section('title') @lang('translation.update_group') - @lang('translation.id') {{ $group->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.groups') @endslot
@slot('title') @lang('translation.update_group') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="update_group">
                    @csrf
                    <input type="hidden" id="group_id" name="group_id" value="{{ $groupId }}">

                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('translation.name')</label>
                        <input type="text" class="form-control" value="{{ $group->name }}" id="name" name="name" autofocus placeholder="@lang('translation.enter_name')">
                    </div>

                    <div class="mb-3">
                        <label for="menu" class="form-label">@lang('translation.menu')</label>
                        <select class="form-control" id="menu" name="menu[]" multiple>
                            @foreach($menu as $item)
                                <option 
                                    value="{{ $item->id }}"
                                    @if(in_array($item->id, $selectedMenusIds)) selected @endif
                                >
                                    {{ $item->name }}
                                 </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $group->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $group->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
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
<script src="{{ asset('build/js/groups/update-group.js') }}"></script>

@endsection