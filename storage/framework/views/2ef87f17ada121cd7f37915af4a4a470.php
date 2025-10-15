<?php
    use App\Classes\User;
    $user = new User;
    $sideBarCards = $user->getSideBarCards();
    $parentCards = $sideBarCards['parent_cards'];
    $childCards = $sideBarCards['child_cards'];
?>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <?php if($parentCards->isNotEmpty()): ?>
                    <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.menu'); ?></li>
                <?php endif; ?>
                <!-- Dynamic Parent and Child Items -->
                <?php $__currentLoopData = $parentCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $childrens = $childCards->where('parent_id', $parent->id);
                        $hasChildrens = $childrens->isNotEmpty();
                    ?>
                    <li class="nav-item">
                        <!-- Parent Item -->
                        <a class="nav-link <?php echo e($hasChildrens ? 'has-arrow waves-effect' : ''); ?>" 
                           href="<?php echo e($hasChildrens ? '#' : route($parent->action_route)); ?>" 
                           <?php if($hasChildrens): ?> aria-expanded="false" <?php endif; ?>>
                            <i class="<?php echo e($parent->icon); ?>"></i>
                            <span><?php echo e($parent->name); ?></span>
                        </a>

                        <!-- Child Items -->
                        <?php if($hasChildrens): ?>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php $__currentLoopData = $childrens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(route($child->action_route)); ?>">
                                            <i class="<?php echo e($child->icon); ?>"></i>
                                            <span><?php echo e($child->name); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End --><?php /**PATH /home/dpe4njh3p6hj/public_html/alhashemya-group/admin/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>