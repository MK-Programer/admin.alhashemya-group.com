@extends('layouts.master')

@section('title')
    @lang('translation.services')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.dashboard')
        @endslot
        @slot('title')
            @lang('translation.services')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            @include('layouts.utils.loading')
            @include('layouts.utils.success-danger')
            <div class="card">
                <div class="card-body">
                    <a href="#" id="create_service" class="btn btn-primary">@lang('translation.create_new_service')</a>
                    <table id="services_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>@lang('translation.id')</th>
                                <th>@lang('translation.picture')</th>
                                <th>@lang('translation.title_en')</th>
                                <th>@lang('translation.title_ar')</th>
                                <th>@lang('translation.description_en')</th>
                                <th>@lang('translation.description_ar')</th>
                                <th>@lang('translation.sequence')</th>
                                <th></th>
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
    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
   
    <!-- Responsive examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    
    {{-- lang --}}
    <script>
        var csrfToken = '{{ csrf_token() }}';
        var updateText = '@lang('translation.update')';
        var deleteText = '@lang('translation.delete')';
    </script>
    
    <script src="{{ URL::asset('build/js/services/services.js') }}"></script>
@endsection
