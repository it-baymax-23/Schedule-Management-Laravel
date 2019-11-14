
<?php if($project && $currantWorkspace): ?>

    <form class="pl-3 pr-3" method="post" action="<?php echo e(route('tasks.store',[$currantWorkspace->slug,$project->id])); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label><?php echo e(__('Project')); ?></label>
            <select class="form-control form-control-light" name="project_id" required>
                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>" <?php if($p->id == $project->id): ?> selected <?php endif; ?>><?php echo e($p->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="task-title"><?php echo e(__('Title')); ?></label>
                    <input type="text" class="form-control form-control-light" id="task-title"
                           placeholder="<?php echo e(__('Enter Title')); ?>" name="title" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="task-priority"><?php echo e(__('Priority')); ?></label>
                    <select class="form-control form-control-light" name="priority" id="task-priority" required>
                        <option value="Low"><?php echo e(__('Low')); ?></option>
                        <option value="Medium"><?php echo e(__('Medium')); ?></option>
                        <option value="High"><?php echo e(__('High')); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="task-description"><?php echo e(__('Description')); ?></label>
            <textarea class="form-control form-control-light" id="task-description" rows="3" name="description"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="assign_to"><?php echo e(__('Assign To')); ?></label>
                    <select class="form-control form-control-light" id="assign_to" name="assign_to" required>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?> - <?php echo e($u->email); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="due_date"><?php echo e(__('Due Date')); ?></label>
                    <input type="text" class="form-control form-control-light date" id="due_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="due_date" required>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <button type="submit" class="btn btn-primary"><?php echo e(__('Create')); ?></button>
        </div>

    </form>
    <script>
        $(document).on('change',"select[name=project_id]",function () {
            $.get('<?php echo e(route('home')); ?>'+'/userProjectJson/'+$(this).val(),function (data) {
                $('select[name=assign_to]').html('');
                data = JSON.parse(data);
                $(data).each(function(i,d){
                    $('select[name=assign_to]').append('<option value="'+d.id+'">'+d.name+' - '+d.email+'</option>');
                });
            })
        })
    </script>

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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/taskCreate.blade.php ENDPATH**/ ?>