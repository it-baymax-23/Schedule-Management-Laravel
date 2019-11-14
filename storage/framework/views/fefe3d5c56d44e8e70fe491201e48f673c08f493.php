<?php $__env->startSection('content'); ?>

    <!-- Start Content-->
    <div class="container-fluid">
    <?php if($currantWorkspace): ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"><?php echo e(__('Projects')); ?></h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

         <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                        <h3><span><?php echo e($totalProject); ?></span></h3>
                                        <p class="text-muted font-15 mb-0"><?php echo e(__('Total Projects')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <div class="card-body text-center">
                                        <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                        <h3><span><?php echo e($totalTask); ?></span></h3>
                                        <p class="text-muted font-15 mb-0"><?php echo e(__('Total Tasks')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <div class="card-body text-center">
                                        <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                        <h3><span><?php echo e($totalMembers); ?></span></h3>
                                        <p class="text-muted font-15 mb-0"><?php echo e(__('Members')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <div class="card-body text-center">
                                        <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                        <h3><span><?php echo e($totalClients); ?></span></h3>
                                        <p class="text-muted font-15 mb-0"><?php echo e(__('Clients')); ?></p>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

            <div class="row">
                <div class="col-12">
                    <div class="card animated">
                        <div class="card-body">

                            <h4 class="header-title mb-4"><?php echo e(__('Tasks Overview')); ?></h4>

                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="task-area-chart"></canvas>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


        <div class="row">
            <div class="col-xl-4">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-4"><?php echo e(__('Project Status')); ?></h4>

                        <div class="my-4 chartjs-chart" style="height: 202px;">
                            <canvas id="project-status-chart"></canvas>
                        </div>

                        <div class="row text-center mt-2 py-2">

                            <?php $__currentLoopData = $arrProcessPer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="col-4">
                                <i class="mdi mdi-trending-up <?php echo e($arrProcessClass[$index]); ?> mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span><?php echo e($value); ?>%</span>
                                </h3>
                                <p class="text-muted mb-0"><?php echo e($arrProcessLable[$index]); ?></p>
                            </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                        <!-- end row-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-8">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3"><?php echo e(__('Tasks')); ?></h4>

                        <p><b><?php echo e($completeTask); ?></b> <?php echo e(__('Tasks completed out of')); ?> <?php echo e($totalTask); ?></p>

                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated">
                                <tbody>
                                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1"><a href="<?php echo e(route('projects.task.board',[$currantWorkspace->slug,$task->project_id])); ?>" class="text-body"><?php echo e($task->title); ?></a></h5>
                                            <span class="text-muted font-13"><?php echo e(__('Due in')); ?> <?php echo e(\App\Utility::get_timeago(strtotime($task->due_date))); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13"><?php echo e(__('Status')); ?></span> <br/>
                                            <?php if($task->status=='todo'): ?>
                                                <span class="badge badge-primary-lighten"><?php echo e(ucfirst($task->status)); ?></span>
                                            <?php elseif($task->status=='in progress'): ?>
                                                <span class="badge badge-warning-lighten"><?php echo e(ucfirst($task->status)); ?></span>
                                            <?php elseif($task->status=='review'): ?>
                                                <span class="badge badge-danger-lighten"><?php echo e(ucfirst($task->status)); ?></span>
                                            <?php elseif($task->status=='done'): ?>
                                                <span class="badge badge-success-lighten"><?php echo e(ucfirst($task->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13"><?php echo e(__('Project')); ?></span>
                                            <h5 class="font-14 mt-1 font-weight-normal"><?php echo e($task->project->name); ?></h5>
                                        </td>
                                        <?php if($currantWorkspace->permission == 'Owner'): ?>
                                        <td>
                                            <span class="text-muted font-13"><?php echo e(__('Assigned to')); ?></span>
                                            <h5 class="font-14 mt-1 font-weight-normal"><?php echo e($task->user->name); ?></h5>
                                        </td>
                                        <?php endif; ?>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->


        <div class="row">
            <div class="col-xl-5">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3"><?php echo e(__('Todo')); ?></h4>

                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated ">
                                <tbody>
                                <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1"><?php echo e($todo->text); ?></h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13"><?php echo e(__('Status')); ?></span> <br/>
                                        <?php if($todo->done): ?>
                                            <span class="badge badge-success-lighten"><?php echo e(__('Done')); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-danger-lighten"><?php echo e(__('Pending')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-7">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3"><?php echo e(__('Your Calendar')); ?></h4>

                        <div class="row">
                            <div class="col-md-7 animated">
                                <div data-provide="datepicker-inline" data-date-today-highlight="true" class="calendar-widget"></div>
                            </div> <!-- end col-->
                            <div class="col-md-5">
                                <ul class="list-unstyled animated">
                                    <?php if(!count($calendars)): ?>
                                    <li class="mb-4">
                                        <h5><?php echo e(__('No Events for today')); ?></h5>
                                    </li>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $calendars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mb-4">
                                            <p class="text-muted mb-1 font-13">
                                                <i class="mdi mdi-calendar"></i> <?php if($calendar->allDay): ?> <?php echo e(__('Full day')); ?> <?php else: ?> <?php echo e(date('h:i A',strtotime($calendar->start))); ?> - <?php echo e(date('h:i A',strtotime($calendar->end))); ?> <?php endif; ?>
                                            </p>
                                            <h5><?php echo e($calendar->title); ?></h5>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

        </div>
        <!-- end row-->

    <?php endif; ?>
    </div>
    <!-- container -->

<?php $__env->stopSection(); ?>
<?php if($currantWorkspace): ?>
<?php $__env->startPush('scripts'); ?>
    <!-- third party js -->
    <script src="<?php echo e(asset('js/vendor/Chart.bundle.min.js')); ?>"></script>
    <!-- third party js ends -->
    <!-- demo app -->
    <script>
        !function (t) {
            "use strict";
            var r = function () {
                this.$body = t("body"), this.charts = []
            };
            r.prototype.respChart = function (r, a, n, e) {
                Chart.defaults.global.defaultFontColor = "#8391a2", Chart.defaults.scale.gridLines.color = "#8391a2";
                var i = r.get(0).getContext("2d"), s = t(r).parent();
                return function () {
                    var o;
                    switch (r.attr("width", t(s).width()), a) {
                        case"Line":
                            o = new Chart(i, {type: "line", data: n, options: e});
                            break;
                        case"Doughnut":
                            o = new Chart(i, {type: "doughnut", data: n, options: e})
                    }
                    return o
                }()
            }, r.prototype.initCharts = function () {
                var r = [];
                if (t("#task-area-chart").length > 0) {
                    r.push(this.respChart(t("#task-area-chart"), "Line", {
                        labels: <?php echo json_encode($chartData['label']); ?>,
                        datasets: [
                            {
                                label: "<?php echo e(__('Todo')); ?>",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#fa5c7c",
                                data: <?php echo json_encode($chartData['todo']); ?>

                            },
                            {
                                label: "<?php echo e(__('In Progress')); ?>",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#727cf5",
                                data: <?php echo json_encode($chartData['progress']); ?>

                            },
                            {
                                label: "<?php echo e(__('Review')); ?>",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#0acf97",
                                borderDash: [5, 5],
                                data: <?php echo json_encode($chartData['review']); ?>

                            },
                            {
                                label: "<?php echo e(__('Done')); ?>",
                                backgroundColor: "rgba(10, 207, 151, 0.3)",
                                borderColor: "#0acf97",
                                data: <?php echo json_encode($chartData['done']); ?>

                            },
                        ]
                    }, {
                        maintainAspectRatio: !1,
                        legend: {display: !1},
                        tooltips: {intersect: !1},
                        hover: {intersect: !0},
                        plugins: {filler: {propagate: !1}},
                        scales: {
                            xAxes: [{reverse: !0, gridLines: {color: "rgba(0,0,0,0.05)"}}],
                            yAxes: [{
                                ticks: {stepSize: 10, display: !1},
                                min: 10,
                                max: 100,
                                display: !0,
                                borderDash: [5, 5],
                                gridLines: {color: "rgba(0,0,0,0)", fontColor: "#fff"}
                            }]
                        }
                    }))
                }
                if (t("#project-status-chart").length > 0) {
                    r.push(this.respChart(t("#project-status-chart"), "Doughnut", {
                        labels: <?php echo json_encode($arrProcessLable); ?>,
                        datasets: [{
                            data: <?php echo json_encode($arrProcessPer); ?>,
                            backgroundColor: ["#0acf97", "#727cf5", "#fa5c7c"],
                            borderColor: "transparent",
                            borderWidth: "3"
                        }]
                    }, {maintainAspectRatio: !1, cutoutPercentage: 80, legend: {display: !1}}))
                }
                return r
            }, r.prototype.init = function () {
                var r = this;
                Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', r.charts = this.initCharts(), t(window).on("resize", function (a) {
                    t.each(r.charts, function (t, r) {
                        try {
                            r.destroy()
                        } catch (t) {
                        }
                    }), r.charts = r.initCharts()
                })
            }, t.ChartJs = new r, t.ChartJs.Constructor = r
        }(window.jQuery), function (t) {
            "use strict";
            t.ChartJs.init()
        }(window.jQuery);

        $(".calendar-widget").datepicker({
            onSelect: function (date) {
                console.log(date);
            }
        })
    </script>
    <!-- end demo js-->
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/taskly-submitted/site/resources/views/home.blade.php ENDPATH**/ ?>