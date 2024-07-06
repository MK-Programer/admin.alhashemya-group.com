@extends('layouts.master')

@section('title') @lang('translation.update_home') - @lang('translation.id') {{ $home->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.home') @endslot
@slot('title') @lang('translation.update_home') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" enctype="multipart/form-data" id="update_home">
                    @csrf
                    <input type="hidden" id="home_id" name="home_id" value="{{ $home->id }}">

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="db_picture" name="db_picture" value="{{ $home->picture }}">
                            <img src = "{{ asset($home->picture) }}" alt="#" class="rounded-circle avatar-lg" id="home_image">
                        </div>
                        <label for="picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="picture" name="picture" autofocus>
                            <label class="input-group-text" for="picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title_en" class="form-label">@lang('translation.title_en')</label>
                        <input type="text" class="form-control" value="{{ $home->title_en }}" id="title_en" name="title_en" autofocus placeholder="@lang('translation.enter_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label">@lang('translation.title_ar')</label>
                        <input type="text" class="form-control" value="{{ $home->title_ar }}" id="title_ar" name="title_ar" autofocus placeholder="@lang('translation.enter_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label">@lang('translation.description_en')</label>
                        <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')">{{ $home->desc_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label">@lang('translation.description_ar')</label>
                        <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')">{{ $home->desc_ar }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $home->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $home->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
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
    <script src="{{ asset('build/js/home/update-home.js') }}"></script>
@endsection
