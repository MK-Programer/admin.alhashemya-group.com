@php
    if ($type == 'partners'){
        $mainTitle = __('translation.partners');
        $title = __('translation.partner');
        $createTitle = __('translation.create_new_partner');
    }else if($type == 'clients'){
        $mainTitle = __('translation.clients');
        $title = __('translation.client');
        $createTitle = __('translation.create_new_client');
    }
@endphp

@extends('layouts.master')

@section('title') {{ $title }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') {{ $mainTitle }} @endslot
@slot('title') {{ $createTitle }} @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="new_partner_or_client">
                    @csrf
                    <input type="hidden" value="{{ $type }}" id="type" name="type">
                    
                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <img alt="#" class="rounded-circle avatar-lg" id="image">
                        </div>
                        <label for="picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="sequence" class="form-label">@lang('translation.sequence')</label>
                        <input type="number" class="form-control" id="sequence" name="sequence" autofocus placeholder="@lang('translation.enter_sequence')">
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

<script src="{{ asset('build/js/partners-or-clients/create-new-partner-or-client.js') }}"></script>

@endsection