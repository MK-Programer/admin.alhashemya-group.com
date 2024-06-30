<!-- JAVASCRIPT -->
<script src="{{ asset('build/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('build/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{ asset('build/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('build/libs/node-waves/waves.min.js')}}"></script>

<!-- lang -->
<script>
    var currentLang = '{{ app()->getLocale() }}';
</script>


@include('layouts.utils.buttons-handler')


@yield('script')

<!-- App js -->
<script src="{{ asset('build/js/app.js')}}"></script>

@yield('script-bottom')