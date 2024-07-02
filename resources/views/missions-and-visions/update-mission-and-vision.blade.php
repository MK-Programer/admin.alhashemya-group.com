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

            <input type="hidden" id="mission_id" name="mission_id" value="{{ $mission->id }}">
            <input type="hidden" id="vision_id" name="vision_id" value="{{ $vision->id }}">

            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('translation.mission')</h4>
                    </div>

                    <div class="mb-3">
                        <div class="text-start mt-2">
                            <input type="hidden" id="mission_db_picture" name="mission_db_picture" value="{{ asset($mission->picture) }}">
                            <img src="{{ asset($mission->picture) }}" alt="#" class="rounded-circle avatar-lg" id="mission_image">
                        </div>
                        <label for="mission_picture">@lang('translation.mission_picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="mission_picture" name="mission_picture" autofocus>
                            <label class="input-group-text" for="mission_picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_en" class="form-label">@lang('translation.mission_title_en')</label>
                        <input type="text" class="form-control" id="mission_title_en" name="mission_title_en" value="{{ $mission->title_en }}" autofocus placeholder="@lang('translation.enter_mission_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="mission_title_ar" class="form-label">@lang('translation.mission_title_ar')</label>
                        <input type="text" class="form-control" id="mission_title_ar" name="mission_title_ar" value="{{ $mission->title_ar }}" autofocus placeholder="@lang('translation.enter_mission_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_en" class="form-label">@lang('translation.mission_description_en')</label>
                        <textarea class="form-control" id="mission_description_en" name="mission_description_en" cols="50" autofocus placeholder="@lang('translation.enter_mission_description_en')">{{ $mission->desc_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mission_description_ar" class="form-label">@lang('translation.mission_description_ar')</label>
                        <textarea class="form-control" id="mission_description_ar" name="mission_description_ar" cols="50" autofocus placeholder="@lang('translation.enter_mission_description_ar')">{{ $mission->desc_ar }}</textarea>
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
                            <input type="hidden" id="vision_db_picture" name="vision_db_picture" value="{{ asset($vision->picture) }}">
                            <img src="{{ asset($vision->picture) }}" alt="#" class="rounded-circle avatar-lg" id="vision_image">
                        </div>
                        <label for="vision_picture">@lang('translation.vision_picture')</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="vision_picture" name="vision_picture" autofocus>
                            <label class="input-group-text" for="vision_picture">@lang('translation.upload')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_en" class="form-label">@lang('translation.vision_title_en')</label>
                        <input type="text" class="form-control" id="vision_title_en" name="vision_title_en" value="{{ $vision->title_en }}" autofocus placeholder="@lang('translation.enter_vision_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="vision_title_ar" class="form-label">@lang('translation.vision_title_ar')</label>
                        <input type="text" class="form-control" id="vision_title_ar" name="vision_title_ar" value="{{ $vision->title_ar }}" autofocus placeholder="@lang('translation.enter_vision_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_en" class="form-label">@lang('translation.vision_description_en')</label>
                        <textarea class="form-control" id="vision_description_en" name="vision_description_en" cols="50" autofocus placeholder="@lang('translation.enter_vision_description_en')">{{ $vision->desc_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="vision_description_ar" class="form-label">@lang('translation.vision_description_ar')</label>
                        <textarea class="form-control" id="vision_description_ar" name="vision_description_ar" cols="50" autofocus placeholder="@lang('translation.enter_vision_description_ar')">{{ $vision->desc_ar }}</textarea>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">@lang('translation.additional_data')</h4>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sequence" class="form-label">@lang('translation.sequence')</label>
                        <input type="number" class="form-control" id="sequence" name="sequence" value="{{ $mission->sequence }}" autofocus placeholder="@lang('translation.enter_sequence')">
                    </div>

                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.create')</button>
            </div>
        </form>       
    </div>
</div>
<!-- end row -->


@endsection
@section('script')

<script src="{{ asset('build/js/missions-and-visions/update-mission-and-vision.js') }}"></script>

@endsection