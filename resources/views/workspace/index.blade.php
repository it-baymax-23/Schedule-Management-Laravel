@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Workspaces')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body">
                    <!-- <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Workspace') }}" data-url="{{route('notes.create',$currantWorkspace->slug)}}">
                        <i class="mdi mdi-plus"></i> {{ __('Create New Workspace') }}
                    </button> -->
                    <button type="button" class="btn btn-danger btn-rounded mb-3" class="dropdown-item notify-item" data-toggle="modal" data-target="#modelCreateWorkspace">
                        <i class="mdi mdi-plus"></i>
                        <span>{{ __('Create New Workspace')}}</span>
                    </button>

                    @if($currantWorkspace)

                    <div class="row">
                        @foreach(Auth::user()->workspace as $workspace)
                        
                        <div class="col-md-4">
                            <div class="card mb-0 mt-3 text-white bg-primary">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        @if(Auth::user()->id == $currantWorkspace->created_by)
                                            <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');" title="{{ __('Remove Me From This Workspace')}}"><i class=" mdi mdi-delete-outline"></i></a>
                                            <form id="remove-workspace-form" action="{{ route('delete_workspace', ['id' => $currantWorkspace->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('remove-workspace-form').submit(): '');" title="{{ __('Leave Me From This Workspace')}}"><i class=" mdi mdi-delete-outline"></i></a>
                                            <form id="remove-workspace-form" action="{{ route('leave_workspace', ['id' => $currantWorkspace->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                    <a href="@if($currantWorkspace->id == $workspace->id)javascript:;@else{{ route('change_workspace',$workspace->id) }}@endif">
                                    <h5 class="card-title text-white mb-0">{{ $workspace->name }}</h5></a>

                                    <div id="cardCollpase2" class="collapse pt-3 show">
                                        @if($currantWorkspace->id == $workspace->id)
                                            <i class="mdi mdi-check"></i>
                                        @endif
                                        @if(isset($workspace->pivot->permission))
                                            @if($workspace->pivot->permission =='Owner')
                                                <span class="badge badge-primary">{{$workspace->pivot->permission}}</span>
                                            @else
                                                <span class="badge badge-secondary">{{__('Shared')}}</span>
                                            @endif
                                        @endif
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        @endforeach

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
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>

    

    
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
</div>
<!-- container -->
@endsection