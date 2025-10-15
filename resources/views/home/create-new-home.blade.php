@extends('layouts.master')

@section('title') @lang('translation.create_new_home') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.home') @endslot
@slot('title') @lang('translation.create_new_home') @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        @include('layouts.utils.loading')
        @include('layouts.utils.success-danger')
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title mb-4">Add Or Update Home</h4> --}}

                <form enctype="multipart/form-data" id="update_home">
                    @csrf

                    <div class="mb-3">
                        <label for="title_en" class="form-label">@lang('translation.title_en')</label>
                        <input type="text" class="form-control" id="title_en" name="title_en" autofocus placeholder="@lang('translation.enter_title_en')">
                    </div>

                    <div class="mb-3">
                        <label for="title_ar" class="form-label">@lang('translation.title_ar')</label>
                        <input type="text" class="form-control" id="title_ar" name="title_ar" autofocus placeholder="@lang('translation.enter_title_ar')">
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label">@lang('translation.description_en')</label>
                        <textarea class="form-control" id="description_en" name="description_en" cols="50" autofocus placeholder="@lang('translation.enter_description_en')"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label">@lang('translation.description_ar')</label>
                        <textarea class="form-control" id="description_ar" name="description_ar" cols="50" autofocus placeholder="@lang('translation.enter_description_ar')"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Add Your Picture Here</label>
                        <input class="form-control" type="file" id="formFile" onChange="mainThamUrl(this)" name="picture">
                        <img class="mt-2" src="" id="mainThmb" alt="">
                    </div>

                    <div>
                        <button class="btn btn-primary waves-effect waves-light" type="submit">@lang('translation.create')</button>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('script')
    <script src="{{ asset('build/js/home/create-new-home.js') }}"></script>
@endsection
