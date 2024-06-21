

<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.profile'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.dashboard'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.profile'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-xl-12">
        <?php echo $__env->make('layouts.utils.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.utils.success-danger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-user-profile">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <div class="text-start mt-2">
                    <img src="<?php echo e(asset($authUser->avatar)); ?>" alt="" class="rounded-circle avatar-lg" id="profile-image">
                </div>
                <label for="avatar"><?php echo app('translator')->get('translation.profile_picture'); ?></label>
                <div class="input-group">
                    <input type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="avatar" name="avatar" autofocus>
                    <label class="input-group-text" for="avatar"><?php echo app('translator')->get('translation.upload'); ?></label>
                </div>
                
                <div class="text-danger" role="alert" id="avatar-error" data-ajax-feedback="avatar"></div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label"><?php echo app('translator')->get('translation.name'); ?></label>
                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($authUser->name); ?>" id="name" name="name" autofocus placeholder="<?php echo app('translator')->get('translation.enter_name'); ?>">
                <div class="text-danger" id="name-error" data-ajax-feedback="name"></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><?php echo app('translator')->get('translation.email'); ?></label>
                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" value="<?php echo e($authUser->email); ?>" name="email" placeholder="<?php echo app('translator')->get('translation.enter_email'); ?>" autofocus>
                <div class="text-danger" id="email-error" data-ajax-feedback="email"></div>
            </div>

            

            <div class="mt-3 d-grid">
                <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
            </div>
        </form>

        <form class="form-horizontal mt-4" method="POST" id="update-password">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="current-password" class="form-label"><?php echo app('translator')->get('translation.current_password'); ?></label>
                <input type="password" class="form-control <?php $__errorArgs = ['current-password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current-password" name="current-password" autofocus placeholder="<?php echo app('translator')->get('translation.enter_current_password'); ?>">
                <div class="text-danger" id="current-password-error" data-ajax-feedback="current-password"></div>
            </div>

            <div class="mb-3">
                <label for="new-password" class="form-label"><?php echo app('translator')->get('translation.new_password'); ?></label>
                <input type="password" class="form-control <?php $__errorArgs = ['new-password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="new-password" name="new-password" autofocus placeholder="<?php echo app('translator')->get('translation.enter_new_password'); ?>">
                <div class="text-danger" id="new-password-error" data-ajax-feedback="new-password"></div>
            </div>

            <div class="mb-3">
                <label for="confirm-new-password" class="form-label"><?php echo app('translator')->get('translation.confirm_new_password'); ?></label>
                <input type="password" class="form-control <?php $__errorArgs = ['confirm-new-password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="confirm-new-password" name="confirm-new-password" autofocus placeholder="<?php echo app('translator')->get('translation.enter_confirm_new_password'); ?>">
                <div class="text-danger" id="confirm-new-password-error" data-ajax-feedback="confirm-new-password"></div>
            </div>

            

            

            <div class="mt-3 d-grid">
                <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit"><?php echo app('translator')->get('translation.update'); ?></button>
            </div>
        </form>
    </div>
</div>
<!-- end row -->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('avatar');
        const profileImage = document.getElementById('profile-image');
        const avatarError = document.getElementById('avatar-error');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Clear any previous error messages
                avatarError.textContent = '';
                
                // Create a temporary URL for the selected file and update the image src
                const imageUrl = URL.createObjectURL(file);
                profileImage.src = imageUrl;

                // Revoke the object URL after the image is loaded
                profileImage.onload = function() {
                    URL.revokeObjectURL(imageUrl);
                };
            } 
            // else {
            //     console.log('No file selected');
            // }
        });
    });

    function resetErrors(){
        $('#avatar-error').text('');
        $('#name-error').text('');
        $('#email-error').text('');

        $('#avatar-error').hide();
        $('#name-error').hide();
        $('#email-error').hide();

        $('#current-password-error').text('');
        $('#new-password-error').text('');
        $('#confirm-new-password-error').text('');

        $('#current-password-error').hide();
        $('#new-password-error').hide();
        $('#confirm-new-password-error').hide();
        
    }

    $('#update-user-profile').on('submit', function(event) {
        event.preventDefault();
        showLoading();
        resetErrors();

        let formData = new FormData(this);
        $.ajax({
            url: "<?php echo e(route('updateUserProfile')); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var msg = response['message'];

                hideLoading();
                setSuccess(msg);

                // Reload the page after 2 seconds (2000 milliseconds)
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(response) {
                var msg = response  .responseJSON['message'];;
                hideLoading();
                setDanger(msg);
                // $('#emailError').text(response.responseJSON.errors.email);
                // $('#nameError').text(response.responseJSON.errors.name);
                // $('#dobError').text(response.responseJSON.errors.dob);
                // $('#avatarError').text(response.responseJSON.errors.avatar);
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\elhashemya_group\resources\views/user/profile.blade.php ENDPATH**/ ?>