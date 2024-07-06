@php
    $authUser = Auth::user();
    $lang = app()->getLocale();
    $nameColumn = $lang === 'ar' ? 'settings.name_ar' : 'settings.name_en';
    $companySettings = DB::table('company_settings_rel')
                            ->select(
                                DB::raw("$nameColumn as name"),
                                'settings.icon',
                                'settings.action_route',
                                'settings.sequence',
                                )
                            ->leftJoin('settings', 'company_settings_rel.setting_id', 'settings.id')
                            ->where('company_settings_rel.company_id', $authUser->company_id)
                            ->orderBy('settings.sequence', 'ASC')
                            ->get();
@endphp

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.menu')</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-bars"></i>
                        <span key="t-dashboards">@lang('translation.dashboard')</span>
                    </a>
                </li>

                @foreach ($companySettings as $companySetting)
                    <li>
                        <a href="{{ route($companySetting->action_route) }}">
                            <i class="{{ $companySetting->icon }}"></i>
                            <span key="t-{{ $companySetting->name }}">{{ $companySetting->name }}</span>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
