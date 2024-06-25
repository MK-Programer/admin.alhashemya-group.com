@extends('layouts.master')

@section('title')
    @lang('translation.services')
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
            <div style="margin-top: 20px">
                @include('layouts.utils.success-danger')
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="services_form" class="form-horizontal">
                        @csrf
                        <table id="services_table" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Picture</th>
                                    <th>Title En</th>
                                    <th>Title Ar</th>
                                    <th>Description En</th>
                                    <th>Description Ar</th>
                                    <th>Sequence</th>
                                </tr>
                            </thead>

                            <tbody id="copy-container">
                                <tr style="display:none" id="div-copy">
                                    <td>
                                        <input type="checkbox" name="chk[]"/>
                                        <input type="hidden" name="id[]"/>
                                    </td>
                                    
                                    <td>
                                        {{-- view by default img from db and when user select img view it --}}
                                        <img alt="#" class="rounded-circle avatar-lg">
                                        {{-- pictures from db --}}
                                        <input type="hidden" name="hidden_picture[]"> 
                                        {{-- selected pictures by user --}}
                                        <input type="file" class="form-control" name="new_picture[]">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="title_en[]">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="title_ar[]">
                                    </td>
                                    
                                    <td>
                                        <textarea class="form-control" name="description_en[]" cols="50"></textarea>
                                    </td>

                                    <td>
                                        <textarea class="form-control" name="description_ar[]" cols="50"></textarea>
                                    </td>

                                    <td>
                                        <input type="number" class="form-control" name="sequence[]">
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                        <input type="button" id="add" class="btn btn-success" onclick="addRow()" value="@lang('translation.add_row')">
                        <input type="button" id="remove" style="display:none" class="btn btn-danger" onclick="deleteRow()" value="@lang('translation.delete_rows')">          
                        <div class="mt-3">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/lang/lang.js') }}"></script>
    {{-- <script src="{{ URL::asset('build/js/escape-brackets.js') }}"></script> --}}
    
    <script src="{{ URL::asset('build/js/unique-id.js') }}"></script>
    <script src="{{ URL::asset('build/js/services/services.js') }}"></script>
    <script>
        $(document).ready(function() {
            var services = <?php echo $services; ?>;
            createFetchedServices(services);
        });
    </script>
@endsection
