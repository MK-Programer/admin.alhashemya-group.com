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
    
    <!-- DataTables Buttons -->
    <link href="{{ asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

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
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filter_from">@lang('translation.from')</label>
                            <input type="date" id="filter_from" class="form-control" placeholder="@lang('translation.from')">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_to">@lang('translation.to')</label>
                            <input type="date" id="filter_to" class="form-control" placeholder="@lang('translation.to')">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_is_reviewed">@lang('translation.is_reviewed')</label>
                            <select id="filter_is_reviewed" class="form-control">
                                <option value="">@lang('translation.all')</option>
                                <option value=1>@lang('translation.yes')</option>
                                <option value=0">@lang('translation.no')</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <div>
                                <button id="btn-filter" class="btn btn-primary">@lang('translation.filter')</button>
                                <button id="btn-reset" class="btn btn-secondary">@lang('translation.reset')</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
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
                    </div>
                    <table id="messages_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('translation.id')</th>
                                <th>@lang('translation.sender_name')</th>
                                <th>@lang('translation.email')</th>
                                <th>@lang('translation.phone_number')</th>
                                <th>@lang('translation.product_id')</th>
                                <th>@lang('translation.subject')</th>
                                <th>@lang('translation.body')</th>
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
    
    <!-- Data Table Buttons -->
    <script src="{{ asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    {{-- lang --}}
    <script>
        var detailsText = '@lang('translation.details')';
        var yesText = '@lang('translation.yes')';
        var noText = '@lang('translation.no')';
        var authUserCompanyId = '{{ $authUser->company_id }}'; 
    </script>
    
    <script src="{{ asset('build/js/messages/all-messages.js') }}"></script>
@endsection
