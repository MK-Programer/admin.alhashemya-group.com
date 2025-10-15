@extends('layouts.master')

@section('title') @lang('translation.update_mission_and_vision') - @lang('translation.id') {{ $mission->id. ' - '.$vision->id }} @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.missions_and_visions') @endslot
@slot('title') @lang('translation.update_mission_and_vision') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <form class="form-horizontal" enctype="multipart/form-data" id="update_mission_vision_form">

            <input type="hidden" id="mission_id" name="mission_id" value="{{ $mission->encrypted_id }}">
            <input type="hidden" id="vision_id" name="vision_id" value="{{ $vision->encrypted_id }}">

            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('translation.mission')</h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="mission_db_picture" name="mission_db_picture" value="{{ $mission->picture }}">
                            <img src="{{ asset($mission->picture) }}" alt="#" class="rounded-circle avatar-lg" id="mission_image">
                        </div>
                        <label for="mission_picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="mission_picture" name="mission_picture" autofocus>
                            <label class="input-group-text" for="mission_picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_en" class="form-label">@lang('translation.title_en')</label>
                        <input type="text" class="form-control" id="mission_title_en" name="mission_title_en" value="{{ $mission->title_en }}" autofocus placeholder="@lang('translation.enter_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_ar" class="form-label">@lang('translation.title_ar')</label>
                        <input type="text" class="form-control" id="mission_title_ar" name="mission_title_ar" value="{{ $mission->title_ar }}" autofocus placeholder="@lang('translation.enter_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_en" class="form-label">@lang('translation.description_en')</label>
                        <textarea class="form-control" id="mission_description_en" name="mission_description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')">{{ $mission->desc_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_ar" class="form-label">@lang('translation.description_ar')</label>
                        <textarea class="form-control" id="mission_description_ar" name="mission_description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')">{{ $mission->desc_ar }}</textarea>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('translation.vision')</h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="vision_db_picture" name="vision_db_picture" value="{{ $vision->picture }}">
                            <img src="{{ asset($vision->picture) }}" alt="#" class="rounded-circle avatar-lg" id="vision_image">
                        </div>
                        <label for="vision_picture">@lang('translation.picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="vision_picture" name="vision_picture" autofocus>
                            <label class="input-group-text" for="vision_picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_en" class="form-label">@lang('translation.title_en')</label>
                        <input type="text" class="form-control" id="vision_title_en" name="vision_title_en" value="{{ $vision->title_en }}" autofocus placeholder="@lang('translation.enter_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_ar" class="form-label">@lang('translation.title_ar')</label>
                        <input type="text" class="form-control" id="vision_title_ar" name="vision_title_ar" value="{{ $vision->title_ar }}" autofocus placeholder="@lang('translation.enter_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_en" class="form-label">@lang('translation.description_en')</label>
                        <textarea class="form-control" id="vision_description_en" name="vision_description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')">{{ $vision->desc_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_ar" class="form-label">@lang('translation.description_ar')</label>
                        <textarea class="form-control" id="vision_description_ar" name="vision_description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')">{{ $vision->desc_ar }}</textarea>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('translation.additional_data')</h4>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">@lang('translation.is_active')</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option disabled selected>@lang('translation.enter_status')</option>
                            <option value="1" {{ $mission->is_active == 1 ? 'selected' : '' }}>@lang('translation.yes')</option>
                            <option value="0" {{ $mission->is_active == 0 ? 'selected' : '' }}>@lang('translation.no')</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.update')</button>
            </div>
        </form>       
    </div>
</div>
<!-- end row -->


@endsection
@section('script')

<script src="{{ asset('build/js/missions-and-visions/update-mission-and-vision.js') }}"></script>

@endsection