@extends('layouts.main')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
    @if($currantWorkspace)
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Projects') }}</h4>
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
                                    <a href="{{ route('projects.index',$currantWorkspace->slug) }}">
                                        <div class="card-body text-center">
                                            <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$totalProject}}</span></h3>
                                            <p class="text-muted font-15 mb-0">{{ __('Total Projects') }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <!-- <a href="#"> -->
                                        <div class="card-body text-center">
                                            <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$totalTask}}</span></h3>
                                            <p class="text-muted font-15 mb-0">{{ __('Total Tasks') }}</p>
                                        </div>
                                    <!-- </a> -->
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <a href="{{ route('users.index',$currantWorkspace->slug) }}">
                                        <div class="card-body text-center">
                                            <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$totalMembers}}</span></h3>
                                            <p class="text-muted font-15 mb-0">{{ __('Members') }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3 animated">
                                <div class="card shadow-none m-0 border-left">
                                    <a href="{{ route('clients.index',$currantWorkspace->slug) }}">
                                        <div class="card-body text-center">
                                            <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$totalClients}}</span></h3>
                                            <p class="text-muted font-15 mb-0">{{ __('Clients') }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-12">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3">{{ __('Your Calendar') }}</h4>

                        <div class="row">
                            <div class="col-md-7 animated">
                                <div data-provide="datepicker-inline" data-date-today-highlight="true" class="calendar-widget"></div>
                            </div> <!-- end col-->
                            <div class="col-md-5">
                                <ul class="list-unstyled animated">
                                    @if(!count($calendars))
                                    <li class="mb-4">
                                        <h5>{{ __('No Events for today') }}</h5>
                                    </li>
                                    @else
                                        @foreach($calendars as $calendar)
                                        <li class="mb-4">
                                            <p class="text-muted mb-1 font-13">
                                                <i class="mdi mdi-calendar"></i> @if($calendar->allDay) {{ __('Full day') }} @else {{date('h:i A',strtotime($calendar->start))}} - {{date('h:i A',strtotime($calendar->end))}} @endif
                                            </p>
                                            <h5>{{$calendar->title}}</h5>
                                        </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-4">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-4">{{ __('Project Status') }}</h4>

                        <div class="my-4 chartjs-chart" style="height: 202px;">
                            <canvas id="project-status-chart"></canvas>
                        </div>

                        <div class="row text-center mt-2 py-2">

                            @foreach($arrProcessPer as $index => $value)

                            <div class="col-4">
                                <i class="mdi mdi-trending-up {{$arrProcessClass[$index]}} mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{$value}}%</span>
                                </h3>
                                <p class="text-muted mb-0">{{$arrProcessLable[$index]}}</p>
                            </div>

                            @endforeach

                        </div>
                        <!-- end row-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-8">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3">{{ __('Tasks') }}</h4>

                        <p><b>{{$completeTask}}</b> {{ __('Tasks completed out of')}} {{$totalTask}}</p>

                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated">
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1"><a href="{{route('projects.task.board',[$currantWorkspace->slug,$task->project_id])}}" class="text-body">{{$task->title}}</a></h5>
                                            <span class="text-muted font-13">{{ __('Due in') }} {{\App\Utility::get_timeago(strtotime($task->due_date))}}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">{{ __('Status') }}</span> <br/>
                                            @if($task->status=='todo')
                                                <span class="badge badge-primary-lighten">{{ucfirst($task->status)}}</span>
                                            @elseif($task->status=='in progress')
                                                <span class="badge badge-warning-lighten">{{ucfirst($task->status)}}</span>
                                            @elseif($task->status=='review')
                                                <span class="badge badge-danger-lighten">{{ucfirst($task->status)}}</span>
                                            @elseif($task->status=='done')
                                                <span class="badge badge-success-lighten">{{ucfirst($task->status)}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">{{ __('Project') }}</span>
                                            <h5 class="font-14 mt-1 font-weight-normal">{{$task->project->name}}</h5>
                                        </td>
                                        @if($currantWorkspace->permission == 'Owner')
                                        <td>
                                            <span class="text-muted font-13">{{ __('Assigned to') }}</span>
                                            <h5 class="font-14 mt-1 font-weight-normal">{{$task->user->name}}</h5>
                                        </td>
                                        @endif

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->

                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-3">{{ __('Todo') }}</h4>

                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated ">
                                <tbody>
                                @foreach($todos as $todo)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">{{$todo->text}}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">{{ __('Status') }}</span> <br/>
                                        @if($todo->done)
                                            <span class="badge badge-success-lighten">{{ __('Done') }}</span>
                                        @else
                                            <span class="badge badge-danger-lighten">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card animated">
                    <div class="card-body">

                        <h4 class="header-title mb-4">{{ __('Tasks Overview') }}</h4>

                        <div class="mt-3 chartjs-chart" style="height: 320px;">
                            <canvas id="task-area-chart"></canvas>
                        </div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
        

    @endif
    </div>
    <!-- container -->

@endsection
@if($currantWorkspace)
@push('scripts')
    <!-- third party js -->
    <script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
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
                        labels: {!! json_encode($chartData['label']) !!},
                        datasets: [
                            {
                                label: "{{ __('Todo') }}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#fa5c7c",
                                data: {!! json_encode($chartData['todo']) !!}
                            },
                            {
                                label: "{{ __('In Progress') }}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#727cf5",
                                data: {!! json_encode($chartData['progress']) !!}
                            },
                            {
                                label: "{{ __('Review') }}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#0acf97",
                                borderDash: [5, 5],
                                data: {!! json_encode($chartData['review']) !!}
                            },
                            {
                                label: "{{ __('Done') }}",
                                backgroundColor: "rgba(10, 207, 151, 0.3)",
                                borderColor: "#0acf97",
                                data: {!! json_encode($chartData['done']) !!}
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
                        labels: {!! json_encode($arrProcessLable) !!},
                        datasets: [{
                            data: {!! json_encode($arrProcessPer) !!},
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
@endpush
@endif
