@php
    use App\Classes\User;
    $authUser = Auth::user();
    $user = new User;
    $userCompanies = $user->getUserCompanies();
@endphp

<style>
    /* Hide the element on screens smaller than 576px */
    @media (max-width: 576px) {
        .hide-on-mobile {
            display: none;
        }
    }    
</style>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ route('dashboard') }}" class="logo">
                    <span class="logo-sm">
                        <img src="{{ asset($authUser->company->logo) }}" alt="" height="50" width="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset($authUser->company->logo) }}" alt="" height="70" width="70">
                    </span>
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img src="{{ asset ($authUser->company->logo) }}" alt="company-logo" class="me-1" height="50" width="50">
                        <span class="align-middle hide-on-mobile">
                            @switch(app()->getLocale())
                                @case('en')
                                    {{ $authUser->company->name_en }}
                                @break
                                @case('ar')
                                    {{ $authUser->company->name_ar }}    
                                @break
                            @endswitch
                        </span>

                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    
                    @foreach ($userCompanies as $company)
                        <!-- item-->
                        <a href="#" class="company-link dropdown-item notify-item" data-id="{{ $company->id }}">
                            <img src="{{ asset ($company->logo) }}" alt="company-logo" class="me-1" height="50" width="50"> 
                                <span class="align-middle">
                                    @switch(app()->getLocale())
                                        @case('en')
                                            {{ $company->name_en }}
                                        @break
                                        @case('ar')
                                            {{ $company->name_ar }}    
                                        @break
                                    @endswitch
                                </span>
                        </a>
                    @endforeach
                </div>
            </div>
    </div>

    <div class="d-flex">

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @switch(app()->getLocale())
                    @case('en')
                        <img src="{{ asset('build/images/flags/us.jpg') }}" alt="Header Language" height="16">
                    @break
                    @case('ar')
                        <img src="{{ asset('build/images/flags/eg.jpg') }}" alt="Header Language" height="16">
                    @break
                        
                @endswitch
            </button>
            <div class="dropdown-menu dropdown-menu-end">

                <!-- item-->
                <a href="{{ url('index/en') }}" class="dropdown-item notify-item language" data-lang="en" id="ltr-mode-switch">
                    <img src="{{ asset ('build/images/flags/us.jpg') }}" alt="US Language Flag" class="me-1" height="12"> <span class="align-middle">@lang('translation.english')</span>
                </a>
                <!-- item-->
                <a href="{{ url('index/ar') }}" class="dropdown-item notify-item language" data-lang="ar" id="rtl-mode-switch">
                    <img src="{{ asset ('build/images/flags/eg.jpg') }}" alt="EG Language Flag" class="me-1" height="12"> <span class="align-middle">@lang('translation.arabic')</span>
                </a>
                
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ isset($authUser->avatar) ? asset($authUser->avatar) : asset('/build/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst($authUser->name)}}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('showUserProfile') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('translation.profile')</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); ltrSwitchMode(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('translation.logout')</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="bx bx-cog bx-spin"></i>
            </button>
        </div>
    </div>
</header>

