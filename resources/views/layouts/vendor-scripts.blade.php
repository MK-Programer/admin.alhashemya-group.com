<!-- JAVASCRIPT -->
<script src="{{ asset('build/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('build/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{ asset('build/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('build/libs/node-waves/waves.min.js')}}"></script>
<script src="{{ asset('build/js/sweetalert2.min.js') }}"></script>


<script>
    // lang
    var currentLang = '{{ app()->getLocale() }}';

    // assetPath
    var assetPath = '{{ asset('') }}';

    var error = '@lang('translation.error')';
    var error400 = '@lang('translation.error_400')';
    var error500 = '@lang('translation.error_500')';
    var ok = '@lang('translation.ok')';
</script>

@include('layouts.utils.buttons-handler')


@yield('script')
<!-- App js -->
<script src="{{ asset('build/js/app.js')}}"></script>
<script src="{{ asset('build/js/companies/change-user-company.js') }}"></script>
<script src="{{ asset('build/js/lang/change-app-direction.js') }}"></script>
<script src="{{ asset('build/js/popups/danger.js') }}"></script>

@yield('script-bottom')