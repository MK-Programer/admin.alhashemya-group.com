@extends('layouts.master')

@section('title')
    @lang('translation.products')
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
            @lang('translation.products')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-0 mb-3">
                        <a href="{{ route('showCreateProduct') }}" id="create_product" class="btn btn-primary">@lang('translation.create_new_product')</a>
                    </div>
                    <table id="products_table" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>@lang('translation.id')</th>
                                <th>@lang('translation.picture')</th>
                                <th>@lang('translation.title_en')</th>
                                <th>@lang('translation.title_ar')</th>
                                <th>@lang('translation.description_en')</th>
                                <th>@lang('translation.description_ar')</th>
                                <th>@lang('translation.is_active')</th>
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
        var updateText = '@lang('translation.update')';
        var yesText = '@lang('translation.yes')';
        var noText = '@lang('translation.no')';
    </script>

    <script src="{{ asset('build/js/products/all-products.js') }}"></script>
@endsection
