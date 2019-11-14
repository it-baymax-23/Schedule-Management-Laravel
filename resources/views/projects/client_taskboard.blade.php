@extends('layouts.client_main')

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">
                        {{ __('Task')}}
                    </h4>
                </div>
            </div>
        </div>

        @if($project && $currantWorkspace)
            <div class="row">
                <div class="col-12">

                    <div class="board" data-plugin="dragula" data-containers='{{json_encode($statusClass)}}'>

                        @foreach($tasks as $status => $task)
                            <div class="tasks animated">
                                <h5 class="mt-0 task-header text-uppercase">{{$status}} (<span class="count">{{count($task)}}</span>)</h5>
                                <div id="{{'task-list-'.str_replace(' ','_',$status)}}" data-status="{{$status}}" class="task-list-items">
                                @foreach($task as $taskDetail)
                                    <!-- Task Item -->
                                        <div class="card mb-0" id="{{$taskDetail->id}}">
                                            <div class="card-body p-3">
                                                <small class="float-right text-muted">{{date('d M Y',strtotime($taskDetail->created_at))}}</small>
                                                @if($taskDetail->priority=="High")
                                                    <span class="badge badge-danger">{{ __('High')}}</span>
                                                @elseif($taskDetail->priority=="Medium")
                                                    <span class="badge badge-info">{{ __('Medium')}}</span>
                                                @else
                                                    <span class="badge badge-success">{{ __('Low')}}</span>
                                                @endif
                                                <h5 class="mt-2 mb-2">
                                                    <a href="#" data-ajax-popup="true" data-size="lg" data-title="{{$taskDetail->title}} @if($taskDetail->priority=="High")<span class='badge badge-danger ml-2'>{{ __('High')}}</span>@elseif($taskDetail->priority=="Medium")<span class='badge badge-info'>{{ __('Medium')}}</span>@else<span class='badge badge-success'>{{ __('Low')}}</span>@endif" data-url="{{route('tasks.show',[$currantWorkspace->slug,$taskDetail->project_id,$taskDetail->id,$clientID])}}"
                                                       class="text-body">{{$taskDetail->title}}</a>
                                                </h5>
                                                <p class="mb-0">
                                                    <span class="text-nowrap mb-2 d-inline-block">
                                                            <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                                            <b>{{count($taskDetail->comments)}}</b> {{ __('Comments')}}
                                                        </span>
                                                </p>

                                            </div> <!-- end card-body -->
                                        </div>
                                        <!-- Task Item End -->
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div> <!-- end .board-->
                </div> <!-- end col -->
            </div>
        @else
            <div class="row justify-content-center animated">
                <div class="col-lg-4">
                    <div class="text-center">
                        <img src="{{ asset('images/file-searching.svg') }}" height="90" alt="File not found Image">

                        <h1 class="text-error mt-4">404</h1>
                        <h4 class="text-uppercase text-danger mt-3">{{ __('Page Not Found') }}</h4>
                        <p class="text-muted mt-3">{{ __('It\'s looking like you may have taken a wrong turn. Don\'t worry... it happens to the best of us. Here\'s a little tip that might help you get back on track.')}}</p>

                        <a class="btn btn-info mt-3" href="{{route('home')}}"><i
                                    class="mdi mdi-reply"></i> {{ __('Return Home')}}</a>
                    </div> <!-- end /.text-center-->
                </div> <!-- end col-->
            </div>
        @endif


    </div> <!-- container -->

@endsection
@if($project && $currantWorkspace)
@push('scripts')
    <!-- third party js -->
    <script src="{{ asset('js/vendor/dragula.min.js') }}"></script>
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
                        var project_id = '{{$project->id}}';

                        $("#"+source.id).parent().find('.count').text($("#"+source.id+" > div").length);
                        $("#"+target.id).parent().find('.count').text($("#"+target.id+" > div").length);
                        $.ajax({
                            url:'{{route('tasks.update.order',[$currantWorkspace->slug,$project->id])}}',
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
                            var avatar = (data.user.avatar)?"src='{{asset('/storage/avatars/')}}/"+data.user.avatar+"'":"avatar='"+data.user.name+"'";
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
                        toastr('Success', '{{ __("Comment Added Successfully!")}}', 'success');
                    },
                    error:function (data) {
                        toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                    }
                });
            }
            else{
            toastr('Error', '{{ __("Please write comment!")}}', 'error');
                
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
                    toastr('Success','Comment added successfully','success');
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
                        "                                    <a download href='{{asset('/storage/tasks/')}}/"+data.file+"' class='btn btn-link btn-lg text-muted'>" +
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
                        toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                    }
                }
            });
        });
    </script>
@endpush
@endif