<?php $__env->startSection('content'); ?>

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">
                        <?php echo e(__('Task')); ?>

                        <?php if($currantWorkspace && $currantWorkspace->permission == 'Owner'): ?>
                            <a href="#" class="btn btn-success btn-sm ml-3" data-ajax-popup="true" data-size="lg"
                               data-title="<?php echo e(__('Create New Task')); ?>"
                               data-url="<?php echo e(route('tasks.create',[$currantWorkspace->slug,$project->id])); ?>"><?php echo e(__('Add New')); ?></a>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
        </div>

        <?php if($project && $currantWorkspace): ?>
            <div class="row">
                <div class="col-12">

                    <div class="board" data-plugin="dragula" data-containers='<?php echo e(json_encode($statusClass)); ?>'>

                        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tasks animated">
                                <h5 class="mt-0 task-header text-uppercase"><?php echo e($status); ?> (<span class="count"><?php echo e(count($task)); ?></span>)</h5>
                                <div id="<?php echo e('task-list-'.str_replace(' ','_',$status)); ?>" data-status="<?php echo e($status); ?>" class="task-list-items">
                                <?php $__currentLoopData = $task; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taskDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Task Item -->
                                        <div class="card mb-0" id="<?php echo e($taskDetail->id); ?>">
                                            <div class="card-body p-3">
                                                <small class="float-right text-muted"><?php echo e(date('d M Y',strtotime($taskDetail->created_at))); ?></small>
                                                <?php if($taskDetail->priority=="High"): ?>
                                                    <span class="badge badge-danger"><?php echo e(__('High')); ?></span>
                                                <?php elseif($taskDetail->priority=="Medium"): ?>
                                                    <span class="badge badge-info"><?php echo e(__('Medium')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-success"><?php echo e(__('Low')); ?></span>
                                                <?php endif; ?>
                                                <h5 class="mt-2 mb-2">
                                                    <a href="#" data-ajax-popup="true" data-size="lg" data-title="<?php echo e($taskDetail->title); ?> <?php if($taskDetail->priority=="High"): ?><span class='badge badge-danger ml-2'><?php echo e(__('High')); ?></span><?php elseif($taskDetail->priority=="Medium"): ?><span class='badge badge-info'><?php echo e(__('Medium')); ?></span><?php else: ?><span class='badge badge-success'><?php echo e(__('Low')); ?></span><?php endif; ?>" data-url="<?php echo e(route('tasks.show',[$currantWorkspace->slug,$taskDetail->project_id,$taskDetail->id])); ?>"
                                                       class="text-body"><?php echo e($taskDetail->title); ?></a>
                                                </h5>
                                                <p class="mb-0">
                                                    <span class="text-nowrap mb-2 d-inline-block">
                                                            <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                                            <b><?php echo e(count($taskDetail->comments)); ?></b> <?php echo e(__('Comments')); ?>

                                                        </span>
                                                </p>

                                                <div class="dropdown float-right">
                                                    <a href="#" class="dropdown-toggle text-muted arrow-none"
                                                       data-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical font-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                    <?php if($currantWorkspace->permission == 'Owner'): ?>
                                                        <!-- item-->
                                                        <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Task')); ?>" data-url="<?php echo e(route('tasks.edit',[$currantWorkspace->slug,$taskDetail->project_id,$taskDetail->id])); ?>"><i
                                                                    class="mdi mdi-pencil mr-1"></i><?php echo e(__('Edit')); ?></a>
                                                        <!-- item-->
                                                        <a href="#" class="dropdown-item" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-<?php echo e($taskDetail->id); ?>').submit(): '');"><i
                                                                    class="mdi mdi-delete mr-1"></i><?php echo e(__('Delete')); ?></a>
                                                        <form id="delete-form-<?php echo e($taskDetail->id); ?>" action="<?php echo e(route('tasks.destroy',[$currantWorkspace->slug,$taskDetail->project_id,$taskDetail->id])); ?>" method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    <?php else: ?>
                                                        <!-- item-->
                                                        <a href="#" class="dropdown-item"><i
                                                                    class="mdi mdi-exit-to-app mr-1"></i><?php echo e(__('Leave')); ?></a>
                                                    <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if($currantWorkspace->permission == 'Owner'): ?>
                                                <p class="mb-0">
                                                    <img <?php if($taskDetail->user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$taskDetail->user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($taskDetail->user->name); ?>" <?php endif; ?> alt="user-img"
                                                         class="avatar-xs rounded-circle mr-1"/>
                                                    <span class="align-middle"><?php echo e($taskDetail->user->name); ?></span>
                                                </p>
                                                <?php endif; ?>
                                            </div> <!-- end card-body -->
                                        </div>
                                        <!-- Task Item End -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div> <!-- end .board-->
                </div> <!-- end col -->
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


    </div> <!-- container -->

<?php $__env->stopSection(); ?>
<?php if($project && $currantWorkspace): ?>
<?php $__env->startPush('scripts'); ?>
    <!-- third party js -->
    <script src="<?php echo e(asset('js/vendor/dragula.min.js')); ?>"></script>
    <script>
        !function (a) {
            "use strict";
            var t = function () {
                this.$body = a("body")
            };
            t.prototype.init = function () {
                a('[data-plugin="dragula"]').each(function () {
                    var t = a(this).data("containers"), n = [];
                    if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function (a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function (el, target, source, sibling) {
                        // console.log(el);
                        // console.log(source);
                        // console.log(target);
                        // console.log(sibling);

                        var sort = [];
                        $("#"+target.id+" > div").each(function () {
                            sort[$(this).index()]=$(this).attr('id');
                        });

                        var id = el.id;
                        var old_status = $("#"+source.id).data('status');
                        var new_status = $("#"+target.id).data('status');
                        var project_id = '<?php echo e($project->id); ?>';

                        $("#"+source.id).parent().find('.count').text($("#"+source.id+" > div").length);
                        $("#"+target.id).parent().find('.count').text($("#"+target.id+" > div").length);
                        $.ajax({
                            url:'<?php echo e(route('tasks.update.order',[$currantWorkspace->slug,$project->id])); ?>',
                            type:'PUT',
                            data:{id:id,sort:sort,new_status:new_status,old_status:old_status,project_id:project_id,"_token":$('meta[name="csrf-token"]').attr('content')},
                            success: function(data){
                                // console.log(data);
                            }
                        });
                        // console.log(id);
                        // console.log(status);
                        // console.log(project_id);

                    });


                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery), function (a) {
            "use strict";
            a.Dragula.init()
        }(window.jQuery);
    </script>
    <!-- third party js ends -->
    <script>
        $(document).on('click','#form-comment button',function (e) {
            var comment = $.trim($("#form-comment textarea[name='comment']").val());
            if(comment != ''){
                $.ajax({
                    url:$("#form-comment").data('action'),
                    data:{comment:comment,"_token":$('meta[name="csrf-token"]').attr('content')},
                    type:'POST',
                    success:function (data) {
                        data = JSON.parse(data);

                        if(data.user_type == 'Client'){
                            var avatar = "avatar='"+data.client.name+"'";
                            var html = "<div class='media mt-2 mb-2'>" +
                                "                    <img class='mr-3 avatar-sm rounded-circle img-thumbnail' "+avatar+" alt='"+data.client.name+"'>" +
                                "                    <div class='media-body'>" +
                                "                        <h5 class='mt-0'>"+data.client.name+"</h5>" +
                                "                        "+data.comment +
                                "                    </div>" +
                                "                </div>";
                        }else{
                            var avatar = (data.user.avatar)?"src='<?php echo e(asset('/storage/avatars/')); ?>/"+data.user.avatar+"'":"avatar='"+data.user.name+"'";
                            var html = "<div class='media mt-2 mb-2'>" +
                                "                    <img class='mr-3 avatar-sm rounded-circle img-thumbnail' "+avatar+" alt='"+data.user.name+"'>" +
                                "                    <div class='media-body'>" +
                                "                        <h5 class='mt-0'>"+data.user.name+"</h5>" +
                                "                        "+data.comment +
                                "                    </div>" +
                                "                </div>";
                        }




                        $("#comments").prepend(html);
                        LetterAvatar.transform();
                        $("#form-comment textarea[name='comment']").val('');
                        toastr('Success','<?php echo e(__("Comment Added Successfully!")); ?>','success');
                    },
                    error:function (data) {
                        toastr('Error', '<?php echo e(__("Some Thing Is Wrong!")); ?>', 'error');
                    }
                });
            }
            else{
                toastr('Error','<?php echo e(__("Please write comment!")); ?>','error');
            }
        });
        // $("#form-file").submit(function(e){
        $(document).on('submit','#form-file',function (e) {

            e.preventDefault();
            $.ajax({
                url: $("#form-file").data('action'),
                type: 'POST',
                data: new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data)
                {
                   toastr('Success','<?php echo e(__("Comment Added Successfully!")); ?>','success');
                    // console.log(data);
                    var html = "<div class='card mb-1 shadow-none border'>" +
                        "                        <div class='p-2'>" +
                        "                            <div class='row align-items-center'>" +
                        "                                <div class='col-auto'>" +
                        "                                    <div class='avatar-sm'>" +
                        "                                        <span class='avatar-title rounded text-uppercase'>" +
                        data.extension +
                        "                                        </span>" +
                        "                                    </div>" +
                        "                                </div>" +
                        "                                <div class='col pl-0'>" +
                        "                                    <a href='#' class='text-muted font-weight-bold'>"+data.name+"</a>" +
                        "                                    <p class='mb-0'>"+data.file_size+"</p>" +
                        "                                </div>" +
                        "                                <div class='col-auto'>" +
                        "                                    <!-- Button -->" +
                        "                                    <a download href='<?php echo e(asset('/storage/tasks/')); ?>/"+data.file+"' class='btn btn-link btn-lg text-muted'>" +
                        "                                        <i class='dripicons-download'></i>" +
                        "                                    </a>" +
                        "                                </div>" +
                        "                            </div>" +
                        "                        </div>" +
                        "                    </div>";
                    $("#comments-file").prepend(html);
                },
                error: function(data)
                {
                    data = data.responseJSON;
                    if(data.message) {
                        toastr('Error', data.message, 'error');
                        $('#file-error').text(data.errors.file[0]).show();
                    }
                    else{
                       toastr('Error', '<?php echo e(__("Some Thing Is Wrong!")); ?>', 'error');
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/taskboard.blade.php ENDPATH**/ ?>