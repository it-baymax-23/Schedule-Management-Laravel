<?php $__env->startSection('content'); ?>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo e(__('Notes')); ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <?php if($currantWorkspace): ?>


    <div class="row">
        <div class="col-lg-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create New Note')); ?>" data-url="<?php echo e(route('notes.create',$currantWorkspace->slug)); ?>">
                        <i class="mdi mdi-plus"></i> <?php echo e(__('Create Note')); ?>

                    </button>

                    <div class="row">
                        <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="card mb-0 mt-3 text-white <?php echo e($note->color); ?>">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <a href="#" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Note')); ?>" data-url="<?php echo e(route('notes.edit',[$currantWorkspace->slug,$note->id])); ?>"><i class="mdi mdi-pencil"></i></a>
                                        <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-<?php echo e($note->id); ?>').submit(): '');"><i class="mdi mdi-trash-can    "></i></a>
                                        <form id="delete-form-<?php echo e($note->id); ?>" action="<?php echo e(route('notes.destroy',[$currantWorkspace->slug,$note->id])); ?>" method="POST" style="display: none;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    </div>
                                    <h5 class="card-title mb-0"><?php echo e($note->title); ?></h5>
                                    <div id="cardCollpase2" class="collapse pt-3 show">
                                        <?php echo e($note->text); ?>

                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/notes/index.blade.php ENDPATH**/ ?>