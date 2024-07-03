@extends('layouts.master')

@section('title')
    @lang('translation.messages')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.dashboard')
        @endslot
        @slot('title')
            @lang('translation.messages')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @include('layouts.utils.loading')
            @include('layouts.utils.success-danger')
            <div class="card">
                <div class="card-body">
                    <form style="display: none" id="messages_review_status_form">
                        @csrf
                        <div class="input-group mb-3">
                            <select class="form-control-sm" id="is_reviewed" name="is_reviewed">
                                <option value="1">@lang('translation.yes')</option>
                                <option value="0">@lang('translation.no')</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">@lang('translation.change_to_reviewed')</button>
                            </div>
                        </div>
                    </form>
                    <table id="messages_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('translation.id')</th>
                                <th>@lang('translation.sender_name')</th>
                                <th>@lang('translation.product_id')</th>
                                <th>@lang('translation.subject')</th>
                                <th>@lang('translation.is_reviewed')</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
   
    <!-- Responsive examples -->
    <script src="{{ asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    
    {{-- lang --}}
    <script>
        var detailsText = '@lang('translation.details')';
        var yesText = '@lang('translation.yes')';
        var noText = '@lang('translation.no')';
    </script>
    
    <script src="{{ asset('build/js/messages/all-messages.js') }}"></script>
@endsection
