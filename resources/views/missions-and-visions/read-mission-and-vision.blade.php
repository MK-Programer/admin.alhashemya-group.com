@extends('layouts.master')

@section('title')
    @lang('translation.mission_and_vision_details')
    - 
    @lang('translation.id') {{ $mission->id.' - '.$vision->id }}
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.missions_and_visions') @endslot
@slot('title') @lang('translation.mission_and_vision_details') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.mission')</h4>
                </div>
                <table id="mission_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.mission_picture')</th>
                            <th>@lang('translation.mission_title_en')</th>
                            <th>@lang('translation.mission_title_ar')</th>
                            <th>@lang('translation.mission_description_en')</th>
                            <th>@lang('translation.mission_description_ar')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $mission->id }}</td>
                            <th><img src="{{ asset($mission->picture) }}" alt="#" class="rounded-circle avatar-md"></th>
                            <td>{{ $mission->title_en }}</td>
                            <td>{{ $mission->title_ar }}</td>
                            <td>{{ $mission->desc_en }}</td>
                            <td>{{ $mission->desc_ar }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>    
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.vision')</h4>
                </div>
                <table id="vision_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.vision_picture')</th>
                            <th>@lang('translation.vision_title_en')</th>
                            <th>@lang('translation.vision_title_ar')</th>
                            <th>@lang('translation.vision_description_en')</th>
                            <th>@lang('translation.vision_description_ar')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $vision->id }}</td>
                            <th><img src="{{ asset($vision->picture) }}" alt="#" class="rounded-circle avatar-md"></th>
                            <td>{{ $vision->title_en }}</td>
                            <td>{{ $vision->title_ar }}</td>
                            <td>{{ $vision->desc_en }}</td>
                            <td>{{ $vision->desc_ar }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
        
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.additional_data')</h4>
                </div>
                <table id="vision_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.is_active')</th>
                            <th>@lang('translation.sequence')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@if($mission->is_active == 1) @lang('translation.yes') @else @lang('translation.no') @endif</td>
                            <td>{{ $mission->sequence }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>
<!-- end row -->

@endsection
