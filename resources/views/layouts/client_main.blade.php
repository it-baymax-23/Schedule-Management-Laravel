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

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page" style="margin-left: 0;">
        <div class="content">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <a href="{{ route('home') }}" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('images/logo_taskly.png') }}" alt="" height="16">
                        </span>
                    <span class="logo-sm">
                            <img src="{{ asset('images/logo_taskly.png') }}" alt="" height="16">
                        </span>
                </a>

            </div>
            <!-- end Topbar -->

            @yield('content')

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer" style="left: 0;">
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
        url: function(phrase) {
            return "{{route('search.json',$currantWorkspace->slug)}}/" + phrase ;
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
    <script>toastr('Success','{{ $message }}','success')</script>
@endif

@if ($message = Session::get('error'))
    <script>toastr('Error','{{ $message }}','error')</script>
@endif
</body>

</html>
