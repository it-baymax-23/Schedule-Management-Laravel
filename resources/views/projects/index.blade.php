@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Projects')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if($projects && $currantWorkspace)

    <div class="row mb-2">
        @if($currantWorkspace->creater->id == Auth::user()->id)
        <div class="col-sm-4">
            <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Project') }}" data-url="{{route('projects.create',$currantWorkspace->slug)}}">
                <i class="mdi mdi-plus"></i> {{ __('Create Project') }}
            </button>
        </div>
        @endif
        <div class="col-sm-8">
            <div class="text-sm-right status-filter">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-status="All">{{ __('All')}}</button>
                </div>
                <div class="btn-group mb-3 ml-1">
                    <button type="button" class="btn btn-light" data-status="Ongoing">{{ __('Ongoing')}}</button>
                    <button type="button" class="btn btn-light" data-status="Finished">{{ __('Finished')}}</button>
                    <button type="button" class="btn btn-light" data-status="OnHold">{{ __('OnHold')}}</button>
                </div>

            </div>
        </div><!-- end col-->
    </div>

    <div class="row">

        @foreach ($projects as $project)

            <div class="col-md-6 col-xl-6 animated filter {{$project->status}}">
            <!-- project card -->
                <div class="card d-block project" attr-slug="{{$currantWorkspace->slug}}" attr-id="{{$project->id}}">
                    <div class="card-body">
                        <div class="dropdown card-widgets">
                            <a href="javascript:;" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                                <i class="dripicons-dots-3"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                            @if($currantWorkspace->permission == 'Owner')
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="{{ __('Edit Project') }}" data-url="{{route('projects.edit',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-pencil mr-1"></i>{{ __('Edit')}}</a>
                                    <!-- item-->
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-{{$project->id}}').submit(): '');" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>{{ __('Delete')}}</a>
                                    <form id="delete-form-{{$project->id}}" action="{{ route('projects.destroy',[$currantWorkspace->slug,$project->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item" class="dropdown-item" data-ajax-popup="true" data-size="lg" data-title="{{ __('Invite Users') }}" data-url="{{route('projects.invite.popup',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-email-outline mr-1"></i>{{ __('Invite')}}</a>
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
                        <h4 class="mt-0">
                            <a href="{{route('projects.show',[$currantWorkspace->slug,$project->id])}}" class="text-title">{{ $project->name }}</a>
                        </h4>
                        @if($project->status == 'Finished')
                            <div class="badge badge-success mb-3">{{ __('Finished')}}</div>
                        @elseif($project->status == 'Ongoing')
                            <div class="badge badge-secondary mb-3">{{ __('Ongoing')}}</div>
                        @else
                            <div class="badge badge-warning mb-3">{{ __('OnHold')}}</div>
                        @endif

                        <p class="text-muted font-13 mb-3">
                            {{Str::limit($project->description, $limit = 100, $end = '...')}}
                            <a href="{{route('projects.show',[$currantWorkspace->slug,$project->id])}}" class="font-weight-bold text-muted">{{__('View More')}}</a>
                        </p>

                        <!-- project detail-->
                        <p class="mb-1">
                            <span class="pr-2 text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                                <b>{{$project->countTask()}}</b> {{ __('Tasks')}}
                            </span>
                            <span class="text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                <b>{{$project->countTaskComments()}}</b> {{ __('Comments')}}
                            </span>
                        </p>
                        <div>
                            @foreach($project->users as $user)
                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$user->name}}" class="d-inline-block animated">
                                <img @if($user->avatar) src="{{asset('/storage/avatars/'.$user->avatar)}}" @else avatar="{{ $user->name }}"@endif class="rounded-circle avatar-xs">
                            </a>
                            @endforeach
                        </div>
                    </div> <!-- end card-body-->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <!-- project progress-->
                            <p class="mb-2 font-weight-bold">{{ __('Progress')}} <span class="float-right">{{$project->getProgress()}}%</span></p>
                            <div class="progress progress-sm">
                                <div class="progress-bar @if($project->getProgress() <= 40)bg-danger @elseif($project->getProgress() <= 70)bg-warning @else bg-success @endif" role="progressbar" aria-valuenow="{{$project->getProgress()}}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{$project->getProgress()}}%;">
                                </div><!-- /.progress-bar -->
                            </div><!-- /.progress -->
                        </li>
                    </ul>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="badge badge-danger"> {{$project->countStatus('todo')}} </span> Not Started<br>
                                <span class="badge badge-primary"> {{$project->countStatus('in progress')}} </span> In progress<br>
                            </div>
                        
                            <div class="col-sm-6">
                                <span class="badge badge-warning">{{$project->countStatus('review')}}</span> In Review<br>
                                <span class="badge badge-success"> {{$project->countStatus('done')}} </span> In progress<br>
                            </div>
                        </div>
                        
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
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
</div>
<!-- container -->
@endsection

@push('style')
    <!-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/vendor/bootstrap-tagsinput.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- <script type="text/javascript">
        $('.project').click(function(){
            var slug = $(this).attr('attr-slug');
            var id = $(this).attr('attr-id');
            var url = '{{config('app.url')}}' + '/' + slug + '/projects/' + id;
            window.location.href = url;
        })
    </script> -->
@endpush