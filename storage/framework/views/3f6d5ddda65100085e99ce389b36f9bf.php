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

                <?php $__currentLoopData = $companySettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companySetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route($companySetting->action_route)); ?>">
                            <i class="<?php echo e($companySetting->icon); ?>"></i>
                            <span key="t-dashboards"><?php echo e($companySetting->name); ?></span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                


                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH E:\elhashemya_group\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>