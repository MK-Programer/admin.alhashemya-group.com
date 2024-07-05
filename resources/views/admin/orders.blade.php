@extends('layouts.master')

@section('title') Home @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Admin @endslot
@slot('title') orders @endslot
@endcomponent



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchTableList"
                                    placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                        id="order-list">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20px;" class="align-middle">
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th class="align-middle">Sender Name </th>
                                <th class="align-middle">Sender Email</th>
                                <th class="align-middle">Product Name</th>
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Subject</th>
                                <th class="align-middle">Body</th>
                                <th class="align-middle">status</th>
                                <th class="align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><input class="form-check-input font-size-15" type="checkbox" id="check"></td>
                                    <td>{{ $order->sender_name }}</td>
                                    <td>{{ $order->sender_email }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $order->subject }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#orderdetailsModal_{{ $order->id }}">
                                            View Body
                                        </button>
                                    </td>
                                    <td></td>
                                    <td style="text-align: center" >
                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table responsive -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@foreach ($orders as $order)
        <!-- Modal -->
        <div class="modal fade" id="orderdetailsModal_{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=orderdetailsModalLabel">Body</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word; max-height: auto; overflow-y: auto;">
                        <p class="mb-2">
                            {{ $order->body }}
                        </p>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
@endforeach



@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/build/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>

<script type="text/javascript">
        $('#mainThmb').hide();

	function mainThamUrl(input){
        $('#mainThmb').show();
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmb').attr('src',e.target.result).width(100).height(100);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection
