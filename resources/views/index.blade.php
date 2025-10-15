@extends('layouts.master')

@section('title') @lang('translation.dashboard') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.dashboard') @endslot
@slot('title') @lang('translation.dashboard') @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">@lang('translation.welcome_back')</h5>
                            <p> @lang('translation.at_company') {{ app()->getLocale() == 'en' ? $authUser->company->name_en : $authUser->company->name_ar}}</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('/build/images/profile-img.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ asset($authUser->avatar) }}" alt="#" class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ Str::ucfirst($authUser->name) }}</h5>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{  $newMessages }}</h5>
                                    <p class="text-muted mb-0">@lang('translation.new_messages')</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('showMessages') }}" class="btn btn-primary waves-effect waves-light btn-sm">@lang('translation.view')<i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{  $messagesCount }}</h5>
                                    <p class="text-muted mb-0">@lang('translation.all_messages')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<!-- end modal -->

@endsection
