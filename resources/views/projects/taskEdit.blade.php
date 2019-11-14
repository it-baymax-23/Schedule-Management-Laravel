
@if($project && $currantWorkspace && $task)

    <form class="pl-3 pr-3" method="post" action="{{ route('tasks.update',[$currantWorkspace->slug,$project->id,$task->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>{{ __('Project')}}</label>
            <select class="form-control form-control-light" name="project_id" required>
                @foreach($projects as $p)
                <option value="{{$p->id}}" @if($task->project_id == $p->id) selected @endif>{{$p->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="task-title">{{ __('Title')}}</label>
                    <input type="text" class="form-control form-control-light" id="task-title"
                           placeholder="{{ __('Enter Title')}}" name="title" required value="{{$task->title}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="task-priority">{{ __('Priority')}}</label>
                    <select class="form-control form-control-light" name="priority" id="task-priority" required>
                        <option value="Low" @if($task->priority=='Low') selected @endif>{{ __('Low')}}</option>
                        <option value="Medium" @if($task->priority=='Medium') selected @endif>{{ __('Medium')}}</option>
                        <option value="High" @if($task->priority=='High') selected @endif>{{ __('High')}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="task-description">{{ __('Description')}}</label>
            <textarea class="form-control form-control-light" id="task-description" rows="3" name="description">{{$task->description}}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="assign_to">{{ __('Assign To')}}</label>
                    <select class="form-control form-control-light" id="assign_to" name="assign_to" required>
                        @foreach($users as $u)
                            <option @if($task->assign_to==$u->id) selected @endif value="{{$u->id}}">{{$u->name}} - {{$u->email}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="due_date">{{ __('Due Date')}}</label>
                    <input type="text" value="{{$task->due_date}}" class="form-control form-control-light date" id="due_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="due_date" required>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Cancel')}}</button>
            <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
        </div>

    </form>
    <script>
        $(document).on('change',"select[name=project_id]",function () {
            $.get('{{route('home')}}'+'/userProjectJson/'+$(this).val(),function (data) {
                $('select[name=assign_to]').html('');
                data = JSON.parse(data);
                $(data).each(function(i,d){
                    $('select[name=assign_to]').append('<option value="'+d.id+'">'+d.name+' - '+d.email+'</option>');
                });
            })
        })
    </script>

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