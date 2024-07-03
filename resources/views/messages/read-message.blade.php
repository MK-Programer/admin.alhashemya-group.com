@extends('layouts.master')

@section('title')
    @lang('translation.message_details')
    - 
    @lang('translation.id') {{ $message->id }}
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.messages') @endslot
@slot('title') @lang('translation.message_details') @endslot
@endcomponent

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.sender_details')</h4>
                </div>
                <table id="sender_details_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.sender_name')</th>
                            <th>@lang('translation.sender_email')</th>
                            <th>@lang('translation.phone_number')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->sender_name }}</td>
                            <td>{{ $message->sender_email }}</td>
                            <td>{{ $message->phone_number }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.message')</h4>
                </div>
                <table id="message_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.subject')</th>
                            <th>@lang('translation.body')</th>
                            <th>@lang('translation.is_reviewed')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $message->subject }}</td>
                            <th>{{ $message->body }}</th>
                            <td>{{ @lang('translation.'.$message->is_checked ? 'yes' : 'no') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
        
        <div class="card">
            <div class="card-body">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">@lang('translation.product_details')</h4>
                </div>
                <table id="product_details_table" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>@lang('translation.id')</th>
                            <th>@lang('translation.product_name_en')</th>
                            <th>@lang('translation.product_name_ar')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>
<!-- end row -->

@endsection
