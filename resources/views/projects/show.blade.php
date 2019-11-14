@extends('layouts.main')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Project Detail')}}</h4>
                </div>
            </div>
        </div>

        @if($project && $currantWorkspace)
        <div class="row mb-2">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-8">
                <div class="text-sm-right">
                    <div class="btn-group mb-3">
                        <a href="{{route('projects.task.board',[$currantWorkspace->slug,$project->id])}}" class="btn btn-primary">{{ __('Task Board')}}</a>
                    </div>


                </div>
            </div><!-- end col-->
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-8 animated">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="dripicons-dots-3"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-142px, 20px, 0px);">
                                @if($currantWorkspace->permission == 'Owner')
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="{{ __('Edit Project') }}" data-url="{{route('projects.edit',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-pencil mr-1"></i>{{ __('Edit')}}</a>
                                    <!-- item-->
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-{{$project->id}}').submit(): '');" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>{{__('Delete')}}</a>
                                    <form id="delete-form-{{$project->id}}" action="{{ route('projects.destroy',[$currantWorkspace->slug,$project->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="{{ __('Invite Users') }}" data-url="{{route('projects.invite.popup',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-email-outline mr-1"></i>{{ __('Invite')}}</a>
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="{{ __('Share to Clients') }}" data-url="{{route('projects.share.popup',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-email-outline mr-1"></i>{{ __('Share')}}</a>
                                @else
                                    <!-- item-->
                                        <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('leave-form-{{$project->id}}').submit(): '');" class="dropdown-item"><i class="mdi mdi-exit-to-app mr-1"></i>{{ __('Leave')}}</a>
                                        <form id="leave-form-{{$project->id}}" action="{{ route('projects.leave',[$currantWorkspace->slug,$project->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                @endif
                            </div>
                        </div>
                        <!-- project title-->
                        <h3 class="mt-0">
                           {{$project->name}}
                        </h3>
                        @if($project->status == 'Finished')
                            <div class="badge badge-success mb-3">{{ __('Finished')}}</div>
                        @elseif($project->status == 'Ongoing')
                            <div class="badge badge-secondary mb-3">{{ __('Ongoing')}}</div>
                        @else
                            <div class="badge badge-warning mb-3">{{ __('OnHold')}}</div>
                        @endif

                        <h5>{{ __('Project Overview') }}:</h5>

                        <p class="text-muted mb-2">
                            {{$project->description}}
                        </p>


                        <div class="row">
                            @if($project->start_date)
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>{{ __('Start Date')}}</h5>
                                    <p> {{ date('d M Y',strtotime($project->start_date))}}</p>
                                </div>
                            </div>
                            @endif
                            @if($project->end_date)
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>{{ __('End Date')}}</h5>
                                    <p> {{ date('d M Y',strtotime($project->end_date))}}</p>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>{{ __('Budget')}}</h5>
                                    <p>${{ number_format($project->budget) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h5>{{ __('Team Members') }}:</h5>

                            @foreach($project->users as $user)
                                <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$user->name}}" class="d-inline-block animated">
                                    <img @if($user->avatar) src="{{asset('/storage/avatars/'.$user->avatar)}}" @else avatar="{{ $user->name }}"@endif class="rounded-circle avatar-xs">
                                </a>
                            @endforeach
                        </div>

                    </div> <!-- end card-body-->

                </div> <!-- end card-->


                <!-- end card-->
            </div> <!-- end col -->

            <div class="col-md-4 animated">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ __('Progress')}}</h5>
                        <div class="mt-3 chartjs-chart" style="height: 320px;">
                            <canvas id="line-chart-example"></canvas>
                        </div>
                    </div>
                </div>
                <!-- end card-->


            </div>
        </div>
        @else
            <div class="row justify-content-center animated">
                <div class="col-lg-4">
                    <div class="text-center">
                        <img src="{{ asset('images/file-searching.svg') }}" height="90" alt="File not found Image">

                        <h1 class="text-error mt-4">404</h1>
                        <h4 class="text-uppercase text-danger mt-3">{{ __('Page Not Found') }}</h4>
                        <p class="text-muted mt-3">{{ __('It\'s looking like you may have taken a wrong turn. Don\'t worry... it happens to the best of us. Here\'s a little tip that might help you get back on track.')}}</p>

                        <a class="btn btn-info mt-3" href="{{route('home')}}"><i class="mdi mdi-reply"></i> {{ __('Return Home')}}</a>
                    </div> <!-- end /.text-center-->
                </div> <!-- end col-->
            </div>
        @endif


    </div> <!-- container -->

@endsection

@push('scripts')
    <!-- third party js -->
    <script src="{{ asset('js/vendor/Chart.bundle.min.js') }}"></script>
    <script>

        !function (t) {
            "use strict";
            var a = function () {
                this.$body = t("body"), this.charts = []
            };
            a.prototype.respChart = function (a, e, r, o) {
                var s = Chart.controllers.line.prototype.draw;
                Chart.controllers.line.prototype.draw = function () {
                    s.apply(this, arguments);
                    var t = this.chart.chart.ctx, a = t.stroke;
                    t.stroke = function () {
                        t.save(), t.shadowColor = "rgba(0,0,0,0.01)", t.shadowBlur = 20, t.shadowOffsetX = 0, t.shadowOffsetY = 5, a.apply(this, arguments), t.restore()
                    }
                }, Chart.defaults.global.defaultFontColor = "#8391a2", Chart.defaults.scale.gridLines.color = "#8391a2";
                var n = a.get(0).getContext("2d"), i = t(a).parent();
                return function () {
                    var s;
                    switch (a.attr("width", t(i).width()), e) {
                        case"Line":
                            s = new Chart(n, {type: "line", data: r, options: o});
                            break;
                        case"Doughnut":
                            s = new Chart(n, {type: "doughnut", data: r, options: o});
                            break;
                        case"Pie":
                            s = new Chart(n, {type: "pie", data: r, options: o});
                            break;
                        case"Bar":
                            s = new Chart(n, {type: "bar", data: r, options: o});
                            break;
                        case"Radar":
                            s = new Chart(n, {type: "radar", data: r, options: o});
                            break;
                        case"PolarArea":
                            s = new Chart(n, {data: r, type: "polarArea", options: o})
                    }
                    return s
                }()
            }, a.prototype.initCharts = function () {
                var a = [];
                if (t("#line-chart-example").length > 0) {
                    a.push(this.respChart(t("#line-chart-example"), "Line", {
                        labels: {!! json_encode($chartData['label']) !!},
                        datasets: [
                            {
                                label: "{{ __('Todo')}}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#fa5c7c",
                                data: {!! json_encode($chartData['todo']) !!}
                            },
                            {
                                label: "{{ __('In Progress')}}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#727cf5",
                                data: {!! json_encode($chartData['progress']) !!}
                            },
                            {
                                label: "{{ __('Review')}}",
                                fill: !0,
                                backgroundColor: "transparent",
                                borderColor: "#0acf97",
                                borderDash: [5, 5],
                                data: {!! json_encode($chartData['review']) !!}
                            },
                            {
                                label: "{{ __('Done')}}",
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
                                ticks: {stepSize: 20},
                                display: !0,
                                borderDash: [5, 5],
                                gridLines: {color: "rgba(0,0,0,0)", fontColor: "#fff"}
                            }]
                        }
                    }))
                }
                return a
            }, a.prototype.init = function () {
                var a = this;
                Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', a.charts = this.initCharts(), t(window).on("resize", function (e) {
                    t.each(a.charts, function (t, a) {
                        try {
                            a.destroy()
                        } catch (t) {
                        }
                    }), a.charts = a.initCharts()
                })
            }, t.ChartJs = new a, t.ChartJs.Constructor = a
        }(window.jQuery), function (t) {
            "use strict";
            t.ChartJs.init()
        }(window.jQuery);

    </script>
    <!-- third party js ends -->
@endpush