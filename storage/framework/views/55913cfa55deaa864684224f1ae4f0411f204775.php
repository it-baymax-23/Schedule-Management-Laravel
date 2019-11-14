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
    <link href="<?php echo e(asset('css/easy-autocomplete.min.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body class="" data-keep-enlarged="true">

<!-- Begin page -->
<div class="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu left-side-menu-light">

        <div class="slimscroll-menu" id="left-side-menu-container">

            <!-- LOGO -->
            <a href="<?php echo e(route('home')); ?>" class="logo text-center">
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('images/logo_taskly.png')); ?>" alt="" height="16">
                        </span>
                <span class="logo-sm">
                            <img src="<?php echo e(asset('images/logo_taskly.png')); ?>" alt="" height="16">
                        </span>
            </a>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav side-nav-light">
                <li class="side-nav-item">
                    <a href="<?php echo e(route('home')); ?>" class="side-nav-link">
                        <i class="dripicons-home"></i>
                        <span> <?php echo e(__('Dashboard')); ?> </span>
                    </a>

                </li>
                <?php if($currantWorkspace): ?>
                    <li class="side-nav-item">
                        <a href="<?php echo e(route('projects.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                            <i class="dripicons-briefcase"></i>
                            <span> <?php echo e(__('Projects')); ?> </span>
                        </a>

                    </li>

                    <li class="side-nav-item">
                        <a href="<?php echo e(route('users.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                            <i class="dripicons-network-3"></i>
                            <span> <?php echo e(__('Users')); ?> </span>
                        </a>
                    </li>

                    <?php if($currantWorkspace->creater->id == Auth::user()->id): ?>
                        <li class="side-nav-item">
                            <a href="<?php echo e(route('clients.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                                <i class="dripicons-user"></i>
                                <span> <?php echo e(__('Clients')); ?> </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="side-nav-item">
                        <a href="<?php echo e(route('calendar.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                            <i class="dripicons-calendar"></i>
                            <span> <?php echo e(__('Calendar')); ?> </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?php echo e(route('todos.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                            <i class="dripicons-document-edit"></i>
                            <span> <?php echo e(__('Todo')); ?> </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="<?php echo e(route('notes.index',$currantWorkspace->slug)); ?>" class="side-nav-link">
                            <i class="dripicons-clipboard"></i>
                            <span> <?php echo e(__('Notes')); ?> </span>
                        </a>
                    </li>

                <?php endif; ?>
            </ul>


            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <?php if($currantWorkspace && $currantWorkspace->permission == 'Owner'): ?>
                        <li class="dropdown notification-list topbar-dropdown">

                            <?php
                                $currantLang = basename(App::getLocale());
                            ?>

                            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

                                <span class="align-middle"><?php echo e(Str::upper($currantLang)); ?></span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu">

                            <?php $__currentLoopData = $currantWorkspace->languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($currantLang != $lang): ?>
                                    <!-- item-->
                                        <a href="<?php echo e(route('change_lang_workspace',[$currantWorkspace->id,$lang])); ?>" class="dropdown-item notify-item">

                                            <span class="align-middle"><?php echo e(Str::upper($lang)); ?></span>
                                        </a>
                                    <?php endif; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('lang_workspace',[$currantWorkspace->slug,$currantWorkspace->lang])); ?>" class="dropdown-item notify-item">
                                    <span class="align-middle"><?php echo e(__('Create & Customize')); ?></span>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>


                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                           aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <img <?php if(Auth::user()->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.Auth::user()->avatar)); ?>" <?php else: ?> avatar="<?php echo e(Auth::user()->name); ?>" <?php endif; ?> alt="user-image" class="rounded-circle">
                                    </span>
                            <span>
                                        <span class="account-user-name"><?php echo e(Auth::user()->name); ?></span>
                                        <?php if($currantWorkspace): ?><span class="account-position"><?php echo e($currantWorkspace->permission); ?></span><?php endif; ?>
                                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->

                            <?php $__currentLoopData = Auth::user()->workspace; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php if($currantWorkspace->id == $workspace->id): ?>#<?php else: ?><?php echo e(route('change_workspace',$workspace->id)); ?><?php endif; ?>" class="dropdown-item notify-item">
                                    <?php if($currantWorkspace->id == $workspace->id): ?>
                                        <i class="mdi mdi-check"></i>
                                    <?php endif; ?>
                                    <span><?php echo e($workspace->name); ?></span>
                                    <?php if(isset($workspace->pivot->permission)): ?>
                                        <?php if($workspace->pivot->permission =='Owner'): ?>
                                            <span class="badge badge-primary"><?php echo e($workspace->pivot->permission); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><?php echo e(__('Shared')); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($currantWorkspace): ?>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>
                            <a href="#" class="dropdown-item notify-item" data-toggle="modal" data-target="#modelCreateWorkspace">
                                <i class="mdi mdi-plus"></i>
                                <span><?php echo e(__('Create New Workspace')); ?></span>
                            </a>

                            <?php if($currantWorkspace): ?>
                                <?php if(Auth::user()->id == $currantWorkspace->created_by): ?>
                                    <a href="#" class="dropdown-item notify-item" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');">
                                        <i class=" mdi mdi-delete-outline"></i>
                                        <span><?php echo e(__('Remove Me From This Workspace')); ?></span>
                                    </a>
                                    <form id="remove-workspace-form" action="<?php echo e(route('delete_workspace', ['id' => $currantWorkspace->id])); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                <?php else: ?>
                                    <a href="#" class="dropdown-item notify-item" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');">
                                        <i class=" mdi mdi-delete-outline"></i>
                                        <span><?php echo e(__('Leave Me From This Workspace')); ?></span>
                                    </a>
                                    <form id="remove-workspace-form" action="<?php echo e(route('leave_workspace', ['id' => $currantWorkspace->id])); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="<?php echo e(route('users.my.account')); ?>" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span><?php echo e(__('My Account')); ?></span>
                            </a>

                            <!-- item-->
                            <a href="<?php echo e(route('logout')); ?>" class="dropdown-item notify-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-1"></i>
                                <span><?php echo e(__('Logout')); ?></span>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>

                        </div>
                    </li>

                </ul>
                <div id="modelCreateWorkspace" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCreateWorkspaceLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelCreateWorkspaceLabel"><?php echo e(__('Create Your Workspace')); ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="pl-3 pr-3" method="post" action="<?php echo e(route('add_workspace')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="workspacename"><?php echo e(__('Name')); ?></label>
                                        <input class="form-control" type="text" id="workspacename" name="name" required="" placeholder="<?php echo e(__('Workspace Name')); ?>">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit"><?php echo e(__('Create Workspace')); ?></button>
                                    </div>

                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="app-search">

                        <div class="input-group">
                            <input type="text" id="top-search" class="form-control" placeholder="<?php echo e(__('Search')); ?>">
                            <span class="mdi mdi-magnify"></span>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><?php echo e(__('Search')); ?></button>
                            </div>
                        </div>

                </div>
            </div>
            <!-- end Topbar -->

            <?php echo $__env->yieldContent('content'); ?>

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        Copyright &copy; <?php echo e(env('APP_NAME')); ?> <?php echo e(date('Y')); ?>

                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-md-block">
                            <a href="#"><?php echo e(__('About')); ?></a>
                            <a href="#"><?php echo e(__('Support')); ?></a>
                            <a href="#"><?php echo e(__('Contact Us')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<div id="commanModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCommanModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelCommanModelLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- App js -->

<script src="<?php echo e(asset('js/app.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<script src="<?php echo e(asset('js/scrollreveal.min.js')); ?>"></script>

<?php if($currantWorkspace): ?>
    <script src="<?php echo e(asset('js/jquery.easy-autocomplete.min.js')); ?>"></script>

    <script>
        var options = {
            url: function (phrase) {
                return "<?php echo e(route('search.json',$currantWorkspace->slug)); ?>/" + phrase;
            },
            // url: 'fruitsAndVegetables.json',
            categories: [
                {
                    listLocation: "Projects",
                    header: "<?php echo e(__('Projects')); ?>"
                },
                {
                    listLocation: "Tasks",
                    header: "<?php echo e(__('Tasks')); ?>"
                }
            ],
            getValue: "text",
            template: {
                type: "links",
                fields: {
                    link: "link"
                }
            }
        };
        $("#top-search").easyAutocomplete(options);
    </script>
<?php endif; ?>
<?php echo $__env->yieldPushContent('scripts'); ?>

<?php if($message = Session::get('success')): ?>
    <script>toastr('Success', '<?php echo e($message); ?>', 'success')</script>
<?php endif; ?>

<?php if($message = Session::get('error')): ?>
    <script>toastr('Error', '<?php echo e($message); ?>', 'error')</script>
<?php endif; ?>
</body>

</html>
<?php /**PATH /var/www/html/taskly-submitted/site/resources/views/layouts/main.blade.php ENDPATH**/ ?>