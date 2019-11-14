<?php $__env->startSection('content'); ?>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo e(__('Projects')); ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <?php if($projects && $currantWorkspace): ?>

    <div class="row mb-2">
        <?php if($currantWorkspace->creater->id == Auth::user()->id): ?>
        <div class="col-sm-4">
            <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create New Project')); ?>" data-url="<?php echo e(route('projects.create',$currantWorkspace->slug)); ?>">
                <i class="mdi mdi-plus"></i> <?php echo e(__('Create Project')); ?>

            </button>
        </div>
        <?php endif; ?>
        <div class="col-sm-8">
            <div class="text-sm-right status-filter">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-status="All"><?php echo e(__('All')); ?></button>
                </div>
                <div class="btn-group mb-3 ml-1">
                    <button type="button" class="btn btn-light" data-status="Ongoing"><?php echo e(__('Ongoing')); ?></button>
                    <button type="button" class="btn btn-light" data-status="Finished"><?php echo e(__('Finished')); ?></button>
                    <button type="button" class="btn btn-light" data-status="OnHold"><?php echo e(__('OnHold')); ?></button>
                </div>

            </div>
        </div><!-- end col-->
    </div>

    <div class="row">

        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-6 col-xl-6 animated filter <?php echo e($project->status); ?>">
            <!-- project card -->
                <div class="card d-block project" attr-slug="<?php echo e($currantWorkspace->slug); ?>" attr-id="<?php echo e($project->id); ?>">
                    <div class="card-body">
                        <div class="dropdown card-widgets">
                            <a href="javascript:;" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                                <i class="dripicons-dots-3"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                            <?php if($currantWorkspace->permission == 'Owner'): ?>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Project')); ?>" data-url="<?php echo e(route('projects.edit',[$currantWorkspace->slug,$project->id])); ?>"><i class="mdi mdi-pencil mr-1"></i><?php echo e(__('Edit')); ?></a>
                                    <!-- item-->
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-<?php echo e($project->id); ?>').submit(): '');" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i><?php echo e(__('Delete')); ?></a>
                                    <form id="delete-form-<?php echo e($project->id); ?>" action="<?php echo e(route('projects.destroy',[$currantWorkspace->slug,$project->id])); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Invite Users')); ?>" data-url="<?php echo e(route('projects.invite.popup',[$currantWorkspace->slug,$project->id])); ?>"><i class="mdi mdi-email-outline mr-1"></i><?php echo e(__('Invite')); ?></a>
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Share to Clients')); ?>" data-url="<?php echo e(route('projects.share.popup',[$currantWorkspace->slug,$project->id])); ?>"><i class="mdi mdi-email-outline mr-1"></i><?php echo e(__('Share')); ?></a>
                                <?php else: ?>
                                    <!-- item-->
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('leave-form-<?php echo e($project->id); ?>').submit(): '');" class="dropdown-item"><i class="mdi mdi-exit-to-app mr-1"></i><?php echo e(__('Leave')); ?></a>
                                    <form id="leave-form-<?php echo e($project->id); ?>" action="<?php echo e(route('projects.leave',[$currantWorkspace->slug,$project->id])); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                <?php endif; ?>
                            </div>


                        </div>
                        <!-- project title-->
                        <h4 class="mt-0">
                            <a href="<?php echo e(route('projects.show',[$currantWorkspace->slug,$project->id])); ?>" class="text-title"><?php echo e($project->name); ?></a>
                        </h4>
                        <?php if($project->status == 'Finished'): ?>
                            <div class="badge badge-success mb-3"><?php echo e(__('Finished')); ?></div>
                        <?php elseif($project->status == 'Ongoing'): ?>
                            <div class="badge badge-secondary mb-3"><?php echo e(__('Ongoing')); ?></div>
                        <?php else: ?>
                            <div class="badge badge-warning mb-3"><?php echo e(__('OnHold')); ?></div>
                        <?php endif; ?>

                        <p class="text-muted font-13 mb-3">
                            <?php echo e(Str::limit($project->description, $limit = 100, $end = '...')); ?>

                            <a href="<?php echo e(route('projects.show',[$currantWorkspace->slug,$project->id])); ?>" class="font-weight-bold text-muted"><?php echo e(__('View More')); ?></a>
                        </p>

                        <!-- project detail-->
                        <p class="mb-1">
                            <span class="pr-2 text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                                <b><?php echo e($project->countTask()); ?></b> <?php echo e(__('Tasks')); ?>

                            </span>
                            <span class="text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                <b><?php echo e($project->countTaskComments()); ?></b> <?php echo e(__('Comments')); ?>

                            </span>
                        </p>
                        <div>
                            <?php $__currentLoopData = $project->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo e($user->name); ?>" class="d-inline-block animated">
                                <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($user->name); ?>"<?php endif; ?> class="rounded-circle avatar-xs">
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div> <!-- end card-body-->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <!-- project progress-->
                            <p class="mb-2 font-weight-bold"><?php echo e(__('Progress')); ?> <span class="float-right"><?php echo e($project->getProgress()); ?>%</span></p>
                            <div class="progress progress-sm">
                                <div class="progress-bar <?php if($project->getProgress() <= 40): ?>bg-danger <?php elseif($project->getProgress() <= 70): ?>bg-warning <?php else: ?> bg-success <?php endif; ?>" role="progressbar" aria-valuenow="<?php echo e($project->getProgress()); ?>" aria-valuemin="0" aria-valuemax="100" style="max-width: <?php echo e($project->getProgress()); ?>%;">
                                </div><!-- /.progress-bar -->
                            </div><!-- /.progress -->
                        </li>
                    </ul>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="badge badge-danger"> <?php echo e($project->countStatus('todo')); ?> </span> Not Started<br>
                                <span class="badge badge-primary"> <?php echo e($project->countStatus('in progress')); ?> </span> In progress<br>
                            </div>
                        
                            <div class="col-sm-6">
                                <span class="badge badge-warning"><?php echo e($project->countStatus('review')); ?></span> In Review<br>
                                <span class="badge badge-success"> <?php echo e($project->countStatus('done')); ?> </span> In progress<br>
                            </div>
                        </div>
                        
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php else: ?>

        <div class="row justify-content-center animated">
            <div class="col-lg-4">
                <div class="text-center">
                    <img src="<?php echo e(asset('images/file-searching.svg')); ?>" height="90" alt="File not found Image">

                    <h1 class="text-error mt-4">404</h1>
                    <h4 class="text-uppercase text-danger mt-3"><?php echo e(__('Page Not Found')); ?></h4>
                    <p class="text-muted mt-3"><?php echo e(__('It\'s looking like you may have taken a wrong turn. Don\'t worry... it happens to the best of us. Here\'s a little tip that might help you get back on track.')); ?></p>

                    <a class="btn btn-info mt-3" href="<?php echo e(route('home')); ?>"><i class="mdi mdi-reply"></i> <?php echo e(__('Return Home')); ?></a>
                </div> <!-- end /.text-center-->
            </div> <!-- end col-->
        </div>

    <?php endif; ?>
</div>
<!-- container -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <!-- <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet"> -->
    <link href="<?php echo e(asset('css/vendor/bootstrap-tagsinput.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- <script type="text/javascript">
        $('.project').click(function(){
            var slug = $(this).attr('attr-slug');
            var id = $(this).attr('attr-id');
            var url = '<?php echo e(config('app.url')); ?>' + '/' + slug + '/projects/' + id;
            window.location.href = url;
        })
    </script> -->
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/index.blade.php ENDPATH**/ ?>