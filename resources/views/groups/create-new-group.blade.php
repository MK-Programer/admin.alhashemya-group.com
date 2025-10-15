@extends('layouts.master')

@section('title') @lang('translation.create_new_group') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.groups') @endslot
@slot('title') @lang('translation.create_new_group') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" id="new_group">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('translation.name')</label>
                        <input type="text" class="form-control" id="name" name="name" autofocus placeholder="@lang('translation.enter_name')">
                    </div>

                    <div class="mb-3">
                        <label for="menu" class="form-label">@lang('translation.menu')</label>
                        <select class="form-control" id="menu" name="menu[]" multiple>
                            @foreach($menu as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
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
<script src="{{ asset('build/js/groups/create-new-group.js') }}"></script>
@endsection