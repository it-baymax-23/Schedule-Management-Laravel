
<?php if($currantWorkspace && $task): ?>

    <div class="p-2">
        <h5 class="mt-0"><?php echo e(__('Description')); ?>:</h5>

        <p class="text-muted mb-4">
            <?php echo e($task->description); ?>

        </p>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-4">
                    <h5><?php echo e(__('Create Date')); ?></h5>
                    <p><?php echo e(date('d M Y',strtotime($task->created_at))); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <h5><?php echo e(__('Due Date')); ?></h5>
                    <p><?php echo e(date('d M Y',strtotime($task->due_date))); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <h5><?php echo e(__('Asigned')); ?></h5>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo e($task->user->name); ?>" data-original-title="<?php echo e($task->user->name); ?>" class="d-inline-block">
                        <img <?php if($task->user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$task->user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($task->user->name); ?>" <?php endif; ?> class="rounded-circle avatar-xs" alt="<?php echo e($task->user->name); ?>">
                    </a>
                </div>
            </div>
        </div>
        <!-- end row-->

        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    <?php echo e(__('Comments')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link">
                    <?php echo e(__('Files')); ?>

                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="home-b1">
                <form method="post" id="form-comment" data-action="<?php echo e(route('comment.store',[$currantWorkspace->slug,$task->project_id,$task->id,$clientID])); ?>">
                    <textarea class="form-control form-control-light mb-2" name="comment" placeholder="<?php echo e(__('Write message')); ?>" id="example-textarea" rows="3" required></textarea>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                            <button type="button" class="btn btn-primary btn-sm"><?php echo e(__('Submit')); ?></button>
                        </div>
                    </div>
                </form>
                <div id="comments">
                <?php $__currentLoopData = $task->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="media mt-2 mb-2">
                    <img class="mr-3 avatar-sm rounded-circle img-thumbnail"
                         <?php if($comment->user_type!='Client'): ?>
                            <?php if($comment->user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$comment->user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($comment->user->name); ?>" <?php endif; ?> alt="<?php echo e($comment->user->name); ?>"
                         <?php else: ?>
                            avatar="<?php echo e($comment->client->name); ?>" alt="<?php echo e($comment->client->name); ?>"
                         <?php endif; ?>
                    />
                    <div class="media-body">
                        <h5 class="mt-0"><?php if($comment->user_type!='Client'): ?><?php echo e($comment->user->name); ?><?php else: ?> <?php echo e($comment->client->name); ?> <?php endif; ?></h5>
                        <?php echo e($comment->comment); ?>

                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="tab-pane" id="profile-b1">
                <form method="post" id="form-file" enctype="multipart/form-data" data-action="<?php echo e(route('comment.store.file',[$currantWorkspace->slug,$task->project_id,$task->id,$clientID])); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="file" class="form-control mb-2" name="file" id="file">
                    <span class="invalid-feedback" id="file-error" role="alert">
                        <strong></strong>
                    </span>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                            <button type="submit" class="btn btn-primary btn-sm"><?php echo e(__('Upload')); ?></button>
                        </div>
                    </div>
                </form>
                <div id="comments-file">
                    <?php $__currentLoopData = $task->taskFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-1 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded text-uppercase">
                                            <?php echo e($file->extension); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <a href="#" class="text-muted font-weight-bold"><?php echo e($file->name); ?></a>
                                    <p class="mb-0"><?php echo e($file->file_size); ?></p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a download href="<?php echo e(asset('/storage/tasks/'.$file->file)); ?>" class="btn btn-link btn-lg text-muted">
                                        <i class="dripicons-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

    </div> <!-- .p-2 -->

<?php else: ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center">
                <img src="<?php echo e(asset('images/file-searching.svg')); ?>" height="90" alt="File not found Image">

                <h1 class="text-error mt-4">404</h1>
                <h4 class="text-uppercase text-danger mt-3"><?php echo e(__('Page Not Found')); ?></h4>
                <p class="text-muted mt-3"><?php echo e(__('It\'s looking like you may have taken a wrong turn. Don\'t worry... it happens to the best of us. Here\'s a little tip that might help you get back on track.')); ?></p>
                <a class="btn btn-info mt-3" href="<?php echo e(route('home')); ?>"><i class="mdi mdi-reply"></i> <?php echo e(__('Return Home')); ?></a>
            </div> <!-- end /.text-center-->
        </div> <!-- end col-->
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/taskShow.blade.php ENDPATH**/ ?>