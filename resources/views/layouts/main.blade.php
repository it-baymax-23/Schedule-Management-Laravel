<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Taskly') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet">
    @stack('style')
</head>

<body class="" data-keep-enlarged="true">

<!-- Begin page -->
<div class="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu left-side-menu-light">

        <div class="slimscroll-menu" id="left-side-menu-container">

            <!-- LOGO -->
            <a href="{{ route('home') }}" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('images/logo_taskly.png') }}" alt="" height="16">
                        </span>
                <span class="logo-sm">
                            <img src="{{ asset('images/logo_taskly.png') }}" alt="" height="16">
                        </span>
            </a>

            <!--- Sidemenu -->
            <ul class="metismenu side-nav side-nav-light">
                <li class="side-nav-item">
                    <a href="{{ route('home') }}" class="side-nav-link">
                        <i class="dripicons-home"></i>
                        <span> {{ __('Dashboard') }} </span>
                    </a>

                </li>
                @if($currantWorkspace)
                
                    <li class="side-nav-item">
                        <a href="{{ route('list_workspace',$currantWorkspace->slug) }}" class="side-nav-link">
                            <i class="dripicons-stack"></i>
                            <span> {{ __('Workspace') }} </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="#" class="side-nav-link">
                            <i class="dripicons-phone"></i>
                            <span> {{ __('Lead') }} </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('projects.index',$currantWorkspace->slug) }}" class="side-nav-link">
                            <i class="dripicons-briefcase"></i>
                            <span> {{ __('Projects') }} </span>
                        </a>

                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('users.index',$currantWorkspace->slug) }}" class="side-nav-link">
                            <i class="dripicons-network-3"></i>
                            <span> {{ __('Users') }} </span>
                        </a>
                    </li>

                    @if($currantWorkspace->creater->id == Auth::user()->id)
                        <li class="side-nav-item">
                            <a href="{{ route('clients.index',$currantWorkspace->slug) }}" class="side-nav-link">
                                <i class="dripicons-user"></i>
                                <span> {{ __('Clients') }} </span>
                            </a>
                        </li>
                    @endif

                    <li class="side-nav-item">
                        <a href="{{route('calendar.index',$currantWorkspace->slug)}}" class="side-nav-link">
                            <i class="dripicons-calendar"></i>
                            <span> {{ __('Calendar') }} </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{route('todos.index',$currantWorkspace->slug)}}" class="side-nav-link">
                            <i class="dripicons-document-edit"></i>
                            <span> {{ __('Todo') }} </span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{route('notes.index',$currantWorkspace->slug)}}" class="side-nav-link">
                            <i class="dripicons-clipboard"></i>
                            <span> {{ __('Notes') }} </span>
                        </a>
                    </li>

                @endif
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
                    @if($currantWorkspace && $currantWorkspace->permission == 'Owner')
                        <li class="dropdown notification-list topbar-dropdown">

                            @php
                                $currantLang = basename(App::getLocale());
                            @endphp

                            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">

                                <span class="align-middle">{{Str::upper($currantLang)}}</span> <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu">

                            @foreach($currantWorkspace->languages() as $lang)
                                @if($currantLang != $lang)
                                    <!-- item-->
                                        <a href="{{route('change_lang_workspace',[$currantWorkspace->id,$lang])}}" class="dropdown-item notify-item">

                                            <span class="align-middle">{{Str::upper($lang)}}</span>
                                        </a>
                                    @endif

                                @endforeach
                                <a href="{{route('lang_workspace',[$currantWorkspace->slug,$currantWorkspace->lang])}}" class="dropdown-item notify-item">
                                    <span class="align-middle">{{ __('Create & Customize') }}</span>
                                </a>
                            </div>
                        </li>
                    @endif


                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                           aria-expanded="false">
                            <span class="account-user-avatar">
                                <img @if(Auth::user()->avatar) src="{{asset('/storage/avatars/'.Auth::user()->avatar)}}" @else avatar="{{ Auth::user()->name }}" @endif alt="user-image" class="rounded-circle">
                            </span>
                            <span>
                                <span class="account-user-name">{{ Auth::user()->name }}</span>
                                @if($currantWorkspace)<span class="account-position">{{$currantWorkspace->permission}}</span>@endif
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                            <!-- item-->

                            <!-- @foreach(Auth::user()->workspace as $workspace)
                                <a href="@if($currantWorkspace->id == $workspace->id)#@else{{ route('change_workspace',$workspace->id) }}@endif" class="dropdown-item notify-item">
                                    @if($currantWorkspace->id == $workspace->id)
                                        <i class="mdi mdi-check"></i>
                                    @endif
                                    <span>{{ $workspace->name }}</span>
                                    @if(isset($workspace->pivot->permission))
                                        @if($workspace->pivot->permission =='Owner')
                                            <span class="badge badge-primary">{{$workspace->pivot->permission}}</span>
                                        @else
                                            <span class="badge badge-secondary">{{__('Shared')}}</span>
                                        @endif
                                    @endif
                                </a>
                            @endforeach
                            @if($currantWorkspace)
                                <div class="dropdown-divider"></div>
                            @endif
                            <a href="#" class="dropdown-item notify-item" data-toggle="modal" data-target="#modelCreateWorkspace">
                                <i class="mdi mdi-plus"></i>
                                <span>{{ __('Create New Workspace')}}</span>
                            </a>

                            @if($currantWorkspace)
                                @if(Auth::user()->id == $currantWorkspace->created_by)
                                    <a href="#" class="dropdown-item notify-item" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');">
                                        <i class=" mdi mdi-delete-outline"></i>
                                        <span>{{ __('Remove Me From This Workspace')}}</span>
                                    </a>
                                    <form id="remove-workspace-form" action="{{ route('delete_workspace', ['id' => $currantWorkspace->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <a href="#" class="dropdown-item notify-item" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');">
                                        <i class=" mdi mdi-delete-outline"></i>
                                        <span>{{ __('Leave Me From This Workspace')}}</span>
                                    </a>
                                    <form id="remove-workspace-form" action="{{ route('leave_workspace', ['id' => $currantWorkspace->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            @endif
                            <div class="dropdown-divider"></div> -->

                            <!-- item-->
                            <a href="{{route('users.my.account')}}" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span>{{ __('My Account')}}</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-1"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </li>

                </ul>
                <div id="modelCreateWorkspace" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelCreateWorkspaceLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelCreateWorkspaceLabel">{{ __('Create Your Workspace') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="pl-3 pr-3" method="post" action="{{ route('add_workspace') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="workspacename">{{ __('Name') }}</label>
                                        <input class="form-control" type="text" id="workspacename" name="name" required="" placeholder="{{ __('Workspace Name') }}">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">{{ __('Create Workspace') }}</button>
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
                            <input type="text" id="top-search" class="form-control" placeholder="{{ __('Search')}}">
                            <span class="mdi mdi-magnify"></span>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">{{ __('Search')}}</button>
                            </div>
                        </div>

                </div>
            </div>
            <!-- end Topbar -->

            @yield('content')

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        Copyright &copy; {{ env('APP_NAME') }} {{ date('Y') }}
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-md-block">
                            <a href="#">{{ __('About') }}</a>
                            <a href="#">{{ __('Support') }}</a>
                            <a href="#">{{ __('Contact Us') }}</a>
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

<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/scrollreveal.min.js') }}"></script>

@if($currantWorkspace)
    <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>

    <script>
        var options = {
            url: function (phrase) {
                return "{{route('search.json',$currantWorkspace->slug)}}/" + phrase;
            },
            // url: 'fruitsAndVegetables.json',
            categories: [
                {
                    listLocation: "Projects",
                    header: "{{ __('Projects') }}"
                },
                {
                    listLocation: "Tasks",
                    header: "{{ __('Tasks') }}"
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
@endif
@stack('scripts')

@if ($message = Session::get('success'))
    <script>toastr('Success', '{{ $message }}', 'success')</script>
@endif

@if ($message = Session::get('error'))
    <script>toastr('Error', '{{ $message }}', 'error')</script>
@endif
</body>

</html>
