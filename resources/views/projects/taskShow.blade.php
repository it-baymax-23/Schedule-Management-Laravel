
@if($currantWorkspace && $task)

    <div class="p-2">
        <h5 class="mt-0">{{ __('Description')}}:</h5>

        <p class="text-muted mb-4">
            {{$task->description}}
        </p>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-4">
                    <h5>{{ __('Create Date')}}</h5>
                    <p>{{date('d M Y',strtotime($task->created_at))}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <h5>{{ __('Due Date')}}</h5>
                    <p>{{date('d M Y',strtotime($task->due_date))}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <h5>{{ __('Asigned')}}</h5>
                    <a href="#" data-toggle="tooltip" data-placement="top" title="{{$task->user->name}}" data-original-title="{{$task->user->name}}" class="d-inline-block">
                        <img @if($task->user->avatar) src="{{asset('/storage/avatars/'.$task->user->avatar)}}" @else avatar="{{ $task->user->name }}" @endif class="rounded-circle avatar-xs" alt="{{$task->user->name}}">
                    </a>
                </div>
            </div>
        </div>
        <!-- end row-->

        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    {{ __('Comments')}}
                </a>
            </li>
            <li class="nav-item">
                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link">
                    {{ __('Files')}}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="home-b1">
                <form method="post" id="form-comment" data-action="{{route('comment.store',[$currantWorkspace->slug,$task->project_id,$task->id,$clientID])}}">
                    <textarea class="form-control form-control-light mb-2" name="comment" placeholder="{{ __('Write message')}}" id="example-textarea" rows="3" required></textarea>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                            <button type="button" class="btn btn-primary btn-sm">{{ __('Submit')}}</button>
                        </div>
                    </div>
                </form>
                <div id="comments">
                @foreach($task->comments as $comment)
                <div class="media mt-2 mb-2">
                    <img class="mr-3 avatar-sm rounded-circle img-thumbnail"
                         @if($comment->user_type!='Client')
                            @if($comment->user->avatar) src="{{asset('/storage/avatars/'.$comment->user->avatar)}}" @else avatar="{{ $comment->user->name }}" @endif alt="{{ $comment->user->name }}"
                         @else
                            avatar="{{ $comment->client->name }}" alt="{{ $comment->client->name }}"
                         @endif
                    />
                    <div class="media-body">
                        <h5 class="mt-0">@if($comment->user_type!='Client'){{$comment->user->name}}@else {{$comment->client->name}} @endif</h5>
                        {{$comment->comment}}
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            <div class="tab-pane" id="profile-b1">
                <form method="post" id="form-file" enctype="multipart/form-data" data-action="{{ route('comment.store.file',[$currantWorkspace->slug,$task->project_id,$task->id,$clientID]) }}">
                    @csrf
                    <input type="file" class="form-control mb-2" name="file" id="file">
                    <span class="invalid-feedback" id="file-error" role="alert">
                        <strong></strong>
                    </span>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                            <button type="submit" class="btn btn-primary btn-sm">{{ __('Upload')}}</button>
                        </div>
                    </div>
                </form>
                <div id="comments-file">
                    @foreach($task->taskFiles as $file)
                    <div class="card mb-1 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded text-uppercase">
                                            {{$file->extension}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <a href="#" class="text-muted font-weight-bold">{{$file->name}}</a>
                                    <p class="mb-0">{{$file->file_size}}</p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a download href="{{asset('/storage/tasks/'.$file->file)}}" class="btn btn-link btn-lg text-muted">
                                        <i class="dripicons-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div> <!-- .p-2 -->

@else
    <div class="row justify-content-center">
        <div class="col-lg-12">
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