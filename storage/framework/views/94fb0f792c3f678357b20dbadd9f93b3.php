<?php
    use App\Http\Controllers\UsersController;
    $authUser = Auth::user();
    $usersController = new UsersController;
    $userCompanies = $usersController->getUserCompanies();
?>

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo e(asset('build/images/logo.svg')); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(asset('build/images/logo-dark.png')); ?>" alt="" height="17">
                    </span>
                </a>

                <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo e(asset('build/images/logo-light.svg')); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(asset('build/images/logo-light.png')); ?>" alt="" height="19">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img src="<?php echo e(asset ($authUser->company->logo)); ?>" alt="company-logo" class="me-1" height="50" width="50">
                        <span class="align-middle">
                            <?php switch(app()->getLocale()):
                                case ('en'): ?>
                                    <?php echo e($authUser->company->name_en); ?>

                                <?php break; ?>
                                <?php case ('ar'): ?>
                                    <?php echo e($authUser->company->name_ar); ?>

                                <?php break; ?>
                            <?php endswitch; ?>
                        </span>

                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <?php $__currentLoopData = $userCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- item-->
                        <a href="#" class="company-link dropdown-item notify-item" data-id="<?php echo e($company->id); ?>">
                            <img src="<?php echo e(asset ($company->logo)); ?>" alt="company-logo" class="me-1" height="50" width="50">
                                <span class="align-middle">
                                    <?php switch(app()->getLocale()):
                                        case ('en'): ?>
                                            <?php echo e($company->name_en); ?>

                                        <?php break; ?>
                                        <?php case ('ar'): ?>
                                            <?php echo e($company->name_ar); ?>

                                        <?php break; ?>
                                    <?php endswitch; ?>
                                </span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
    </div>

    <div class="d-flex">

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php switch(app()->getLocale()):
                    case ('en'): ?>
                        <img src="<?php echo e(asset('build/images/flags/us.jpg')); ?>" alt="Header Language" height="16">
                    <?php break; ?>
                    <?php case ('ar'): ?>
                        <img src="<?php echo e(asset('build/images/flags/eg.jpg')); ?>" alt="Header Language" height="16">
                    <?php break; ?>

                <?php endswitch; ?>
            </button>
            <div class="dropdown-menu dropdown-menu-end">

                <!-- item-->
                <a href="<?php echo e(url('index/en')); ?>" class="dropdown-item notify-item language" data-lang="en" id="ltr-mode-switch">
                    <img src="<?php echo e(asset ('build/images/flags/us.jpg')); ?>" alt="US Language Flag" class="me-1" height="12"> <span class="align-middle"><?php echo app('translator')->get('translation.english'); ?></span>
                </a>
                <!-- item-->
                <a href="<?php echo e(url('index/ar')); ?>" class="dropdown-item notify-item language" data-lang="ar" id="rtl-mode-switch">
                    <img src="<?php echo e(asset ('build/images/flags/eg.jpg')); ?>" alt="EG Language Flag" class="me-1" height="12"> <span class="align-middle"><?php echo app('translator')->get('translation.arabic'); ?></span>
                </a>

            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="<?php echo e(isset($authUser->avatar) ? asset($authUser->avatar) : asset('/build/images/users/avatar-1.jpg')); ?>"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo e(ucfirst($authUser->name)); ?></span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="<?php echo e(route('showUserProfile')); ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile"><?php echo app('translator')->get('translation.profile'); ?></span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="bx bx-cog bx-spin"></i>
            </button>
        </div>
    </div>
</div>
</header>

<?php /**PATH C:\laragon\www\elhashemya_group\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>