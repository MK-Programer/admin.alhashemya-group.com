@extends('layouts.master')

@section('title')
    @lang('translation.user_details')
    - 
    @lang('translation.id') {{ $user->id }}
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.users') @endslot
@slot('title') @lang('translation.user_details') @endslot
@endcomponent

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.user_details')</h4>
                </div>
                <table id="user_details_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.picture')</th>
                            <th>@lang('translation.name')</th>
                            <th>@lang('translation.email')</th>
                            <th>@lang('translation.is_active')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><img src="{{ asset($user->avatar) }}" style="max-width:100px;max-height:100px;" alt="#" class="img-thumbnail"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>@if($user->is_active) @lang('translation.yes') @else @lang('translation.no') @endif</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.groups')</h4>
                </div>
                <table id="groups_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.name')</th>
                            <th>@lang('translation.is_active')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userGroups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <th>{{ $group->name }}</th>
                                <td>@if($group->is_active) @lang('translation.yes') @else @lang('translation.no') @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  
        
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.menu')</h4>
                </div>
                <table id="menu_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.name_en')</th>
                            <th>@lang('translation.name_ar')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availableCards as $card)
                            <tr>
                                <td>{{ $card->menu_id }}</td>
                                <td>{{ $card->name_en }}</td>
                                <td>{{ $card->name_ar }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>
<!-- end row -->

@endsection
