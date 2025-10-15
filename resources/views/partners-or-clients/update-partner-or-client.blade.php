@php
    if ($type == 'partners'){
        $mainTitle = __('translation.partners');
        $title = __('translation.update_partner');
    }else if($type == 'clients'){
        $mainTitle = __('translation.clients');
        $title = __('translation.update_client');
    }
@endphp

@extends('layouts.master')

@section('title') {{ $title }} - @lang('translation.id') {{ $partnerOrClient->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') {{ $mainTitle }} @endslot
@slot('title') {{ $title }} @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_partner_or_client">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $partnerOrClientid }}">
                    <input type="hidden" id="type" name="type" value="{{ $type }}">
                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="{{ $partnerOrClient->picture }}">
                            <img src = "{{ asset($partnerOrClient->picture) }}" alt="#" class="rounded-circle avatar-lg" id="image">
                        </div>
                        <label for="picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label">@lang('translation.name_en')</label>
                        <input type="text" class="form-control" value="{{ $partnerOrClient->title_en }}" id="name_en" name="name_en" autofocus placeholder="@lang('translation.enter_name_en')">
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">@lang('translation.name_ar')</label>
                        <input type="text" class="form-control" value="{{ $partnerOrClient->title_ar }}" id="name_ar" name="name_ar" autofocus placeholder="@lang('translation.enter_name_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="sequence" class="form-label">@lang('translation.sequence')</label>
                        <input type="number" class="form-control" value="{{ $partnerOrClient->sequence }}" id="sequence" name="sequence" autofocus placeholder="@lang('translation.enter_sequence')">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $partnerOrClient->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $partnerOrClient->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
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

<script src="{{ asset('build/js/partners-or-clients/update-partner-or-client.js') }}"></script>

@endsection