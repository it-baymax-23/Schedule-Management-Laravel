<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Taskly')); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.ico')); ?>">

    <!-- App css -->
    <link href="<?php echo e(asset('css/icons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.min.css')); ?>" rel="stylesheet">
</head>
<body class="auth-fluid-pages pb-0">

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-left">
                    <a href="#">
                        <span><img src="<?php echo e(asset('images/logo-light.png')); ?>" alt="" height="30"></span>
                    </a>
                </div>

                <?php echo $__env->yieldContent('content'); ?>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3"><?php echo e(__('Claiming your power is an inside job.')); ?></h2>
            <p>
                - <?php echo e(config('app.name', 'Taskly')); ?>

            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- App js -->
<script src="<?php echo e(asset('js/app.min.js')); ?>"></script>

</body>
</html>
<?php /**PATH /var/www/html/taskly-submitted/site/resources/views/layouts/auth.blade.php ENDPATH**/ ?>