<?php
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
?>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.menu'); ?></li>

                <li>
                    <a href="<?php echo e(route('dashboard')); ?>">
                        <i class="fas fa-bars"></i>
                        <span key="t-dashboards"><?php echo app('translator')->get('translation.dashboard'); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('showHome')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Home</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('showServices')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Services</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('showAboutUs')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">AboutUs</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('showCategories')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Categories</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('showProducts')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Products</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('showCompany')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Comany</span>
                    </a>

                </li>
                <li>
                    <a href="<?php echo e(route('admin.orders')); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">orders</span>
                    </a>

                </li>

                



                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\laragon\www\elhashemya_group\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>