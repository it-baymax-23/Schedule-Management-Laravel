<?php $__env->startSection('content'); ?>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo e(__('Workspaces')); ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body">
                    <!-- <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create New Workspace')); ?>" data-url="<?php echo e(route('notes.create',$currantWorkspace->slug)); ?>">
                        <i class="mdi mdi-plus"></i> <?php echo e(__('Create New Workspace')); ?>

                    </button> -->
                    <button type="button" class="btn btn-danger btn-rounded mb-3" class="dropdown-item notify-item" data-toggle="modal" data-target="#modelCreateWorkspace">
                        <i class="mdi mdi-plus"></i>
                        <span><?php echo e(__('Create New Workspace')); ?></span>
                    </button>

                    <?php if($currantWorkspace): ?>

                    <div class="row">
                        <?php $__currentLoopData = Auth::user()->workspace; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="col-md-4">
                            <div class="card mb-0 mt-3 text-white bg-primary">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <?php if(Auth::user()->id == $currantWorkspace->created_by): ?>
                                            <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');" title="<?php echo e(__('Remove Me From This Workspace')); ?>"><i class=" mdi mdi-delete-outline"></i></a>
                                            <form id="remove-workspace-form" action="<?php echo e(route('delete_workspace', ['id' => $currantWorkspace->id])); ?>" method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        <?php else: ?>
                                            <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');" title="<?php echo e(__('Leave Me From This Workspace')); ?>"><i class=" mdi mdi-delete-outline"></i></a>
                                            <form id="remove-workspace-form" action="<?php echo e(route('leave_workspace', ['id' => $currantWorkspace->id])); ?>" method="POST" style="display: none;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php if($currantWorkspace->id == $workspace->id): ?>javascript:;<?php else: ?><?php echo e(route('change_workspace',$workspace->id)); ?><?php endif; ?>">
                                    <h5 class="card-title text-white mb-0"><?php echo e($workspace->name); ?></h5></a>

                                    <div id="cardCollpase2" class="collapse pt-3 show">
                                        <?php if($currantWorkspace->id == $workspace->id): ?>
                                            <i class="mdi mdi-check"></i>
                                        <?php endif; ?>
                                        <?php if(isset($workspace->pivot->permission)): ?>
                                            <?php if($workspace->pivot->permission =='Owner'): ?>
                                                <span class="badge badge-primary"><?php echo e($workspace->pivot->permission); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary"><?php echo e(__('Shared')); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
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
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>

    

    
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
</div>
<!-- container -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/workspace/index.blade.php ENDPATH**/ ?>