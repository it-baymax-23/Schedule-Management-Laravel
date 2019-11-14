@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Calendar')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if($currantWorkspace)

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg font-16 btn-primary btn-block  ">
                                    <i class="mdi mdi-plus-circle-outline"></i> {{ __('Create New Event')}}
                                </a>
                                <div id="external-events" class="m-t-20">
                                    <br>
                                    <p class="text-muted">{{ __('Drag and drop your event or click in the calendar')}}</p>
                                    @foreach($events as $event)
                                    <div class="external-event bg-{{$event->className}}" data-event-id="{{$event->id}}" data-class="bg-{{$event->className}}">
                                        <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>{{$event->title}}
                                    </div>
                                    @endforeach
                                </div>

                                <!-- checkbox -->
                                <div class="custom-control custom-checkbox mt-3">
                                    <input type="checkbox" class="custom-control-input" id="drop-remove">
                                    <label class="custom-control-label" for="drop-remove">{{ __('Remove after drop')}}</label>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-9">
                                <div id="calendar"></div>
                            </div> <!-- end col -->

                        </div>  <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->

                <!-- Add New Event MODAL -->
                <div class="modal fade" id="event-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header pr-4 pl-4 border-bottom-0 d-block">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">{{ __('Add New Event')}}</h4>
                            </div>
                            <div class="modal-body pt-3 pr-4 pl-4">
                            </div>
                            <div class="text-right pb-4 pr-4">
                                <button type="button" class="btn btn-light " data-dismiss="modal">{{ __('Close')}}</button>
                                <button type="button" class="btn btn-success save-event">{{ __('Create Event')}}</button>
                                <button type="button" class="btn btn-danger delete-event" data-dismiss="modal">{{ __('Delete')}}</button>
                            </div>
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->

                <!-- Modal Add Category -->
                <div class="modal fade" id="add-category" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0 d-block">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">{{ __('Add a Event')}}</h4>
                            </div>
                            <div class="modal-body p-4">
                                <form method="post" id="addEvent" onsubmit="return false;">
                                    <div class="form-group">
                                        <label class="control-label">{{ __('Event Name')}}</label>
                                        <input class="form-control form-white" placeholder="{{ __('Enter name')}}" type="text" name="category-name"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('Choose Event Color')}}</label>
                                        <select class="form-control form-white" data-placeholder="{{ __('Choose a color')}}" name="category-color">
                                            <option value="primary">{{ __('Primary')}}</option>
                                            <option value="success">{{ __('Success')}}</option>
                                            <option value="danger">{{ __('Danger')}}</option>
                                            <option value="info">{{ __('Info')}}</option>
                                            <option value="warning">{{ __('Warning')}}</option>
                                            <option value="dark">{{ __('Dark')}}</option>
                                        </select>
                                    </div>

                                </form>

                                <div class="text-right">
                                    <button type="button" class="btn btn-light " data-dismiss="modal">{{ __('Close')}}</button>
                                    <button type="button" class="btn btn-primary ml-1   save-category" data-dismiss="modal">{{ __('Save')}}</button>
                                </div>

                            </div> <!-- end modal-body-->
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->
            </div>
            <!-- end col-12 -->
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

@if($currantWorkspace)
@push('style')
    <link href="{{ asset('css/vendor/fullcalendar.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <!-- third party js -->
    <script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/vendor/fullcalendar.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script>
        !function (e) {
            "use strict";
            var t = function () {
                this.$body = e("body"), this.$modal = e("#event-modal"), this.$event = "#external-events div.external-event", this.$calendar = e("#calendar"), this.$saveCategoryBtn = e(".save-category"), this.$categoryForm = e("#add-category form"), this.$extEvents = e("#external-events"), this.$calendarObj = null
            };
            t.prototype.onDrop = function (t, n) {
                // console.log('onDrop');
                var l = this;
                var view = l.$calendarObj.fullCalendar('getView').name;
                var event_id = t.attr("data-event-id");


                e("#drop-remove").is(":checked") && t.remove()

                var remove_event = 0;
                if(e("#drop-remove").is(":checked")){
                    remove_event = 1;
                }
                var allDay = 0;
                if(view =='month'){
                    allDay = 1;
                }
                $.ajax({
                    url:'{{route('calendar.store',$currantWorkspace->slug)}}',
                    type:'POST',
                    data:{event_id:event_id,start:n.format('YYYY-MM-DD HH:mm:ss'),allDay:allDay,remove_event:remove_event,_token:$('meta[name="csrf-token"]').attr('content')},
                    success:function (data) {
                        data = JSON.parse(data);
                        var a = t.data("eventObject"), c = t.attr("data-class"), i = e.extend({}, a);
                        i.start = n, c && (i.className = c), i.id = data.id;
                        l.$calendarObj.fullCalendar("renderEvent", i, !0)
                        toastr('Success','{{ __("Event Added Successfully!")}}','success');
                    },
                    error:function(data){
                        data = data.responseJSON;
                        if(data.message) {
                            toastr('Error', data.message, 'error');
                        }
                        else{
                            toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    }
                });

            }, t.prototype.onEventClick = function (t, n, a) {
                // console.log('onEventClick');

                var l = this, i = e("<form></form>");
                i.append("<label>{{ __('Change event name')}}</label>"), i.append("<div class='input-group m-b-15'><input class='form-control' type=text value='" + t.title + "' /><input class='form-control' type=hidden name='id' value='" + t.id + "' /><span class='input-group-append'><button type='submit' class='btn btn-success btn-md  '><i class='fa fa-check'></i> {{ __('Save')}}</button></span></div>"), l.$modal.modal({backdrop: "static"}), l.$modal.find(".delete-event").show().end().find(".save-event").hide().end().find(".modal-body").empty().prepend(i).end().find(".delete-event").unbind("click").click(function () {
                    l.$calendarObj.fullCalendar("removeEvents", function (e) {
                        return e._id == t._id
                    }), l.$modal.modal("hide")
                }), l.$modal.find("form").on("submit", function (e) {
                    e.preventDefault();
                    var e = i.find("input[type=text]").val();
                    if(null !== e && 0 != e.length) {
                        $.ajax({
                            url: '{{route('calendar.update',$currantWorkspace->slug)}}',
                            type: 'PUT',
                            data: {
                                title: i.find("input[type=text]").val(),
                                id: i.find("input[type=hidden]").val(),
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                toastr('Success', '{{ __("Event Updated Successfully!")}}', 'success');
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                if (data.message) {
                                    toastr('Error', data.message, 'error');
                                } else {
                                    toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                                }
                            }
                        });
                        return t.title = i.find("input[type=text]").val(), l.$calendarObj.fullCalendar("updateEvent", t), l.$modal.modal("hide"), !1
                    }
                    else{
                        toastr('Error',"{{ __('You have to give a title to your event')}}",'error');
                        return false;
                    }
                }),l.$modal.find('.delete-event').on('click',function(){

                    $.ajax({
                        url:'{{route('calendar.destroy',$currantWorkspace->slug)}}',
                        type:'DELETE',
                        data:{id:i.find("input[type=hidden]").val(),_token:$('meta[name="csrf-token"]').attr('content')},
                        success:function (data) {
                            toastr('Success','{{ __("Event Deleted Successfully!")}}','success');
                        },
                        error:function(data){
                            data = data.responseJSON;
                            if(data.message) {
                                toastr('Error', data.message, 'error');
                            }
                            else{
                                toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                            }
                        }
                    });
                })
            }, t.prototype.onSelect = function (t, n, a) {
                // console.log('onSelect');

                var l = this;
                l.$modal.modal({backdrop: "static"});
                var i = e("<form></form>");
                i.append("<div class='row'></div>"), i.find(".row").append("<div class='col-12'><div class='form-group'><label class='control-label'>{{ __('Event Name')}}</label><input class='form-control' placeholder='{{ __('Insert Event Name')}}' type='text' name='title'/></div></div>").append("<div class='col-12'><div class='form-group'><label class='control-label'>{{ __('Category')}}</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option value='danger'>{{ __('Danger')}}</option>").append("<option value='success'>{{ __('Success')}}</option>").append("<option value='primary'>{{ __('Primary')}}</option>").append("<option value='info'>{{ __('Info')}}</option>").append("<option value='dark'>{{ __('Dark')}}</option>").append("<option value='warning'>{{ __('Warning')}}</option></div></div>"), l.$modal.find(".delete-event").hide().end().find(".save-event").show().end().find(".modal-body").empty().prepend(i).end().find(".save-event").unbind("click").click(function () {
                    i.submit()
                }), l.$modal.find("form").on("submit", function (e) {
                    e.preventDefault();
                    var e = i.find("input[name='title']").val(),
                        a = (i.find("input[name='beginning']").val(), i.find("input[name='ending']").val(), i.find("select[name='category'] option:checked").val());

                    if(null !== e && 0 != e.length) {
                        $.ajax({
                            url: '{{route('calendar.store',$currantWorkspace->slug)}}',
                            type: 'POST',
                            data: {title: e,start:t.format('YYYY-MM-DD HH:mm:ss'),end:n.format('YYYY-MM-DD HH:mm:ss'),allDay: 0, className: a, _token: $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                data= JSON.parse(data);
                                toastr('Success', '{{ __("Event Added Successfully!")}}', 'success');
                                return (l.$calendarObj.fullCalendar("renderEvent", {
                                    id:data.id,
                                    title: e,
                                    start: t,
                                    end: n,
                                    allDay: !1,
                                    className: 'bg-'+a
                                }, !0), l.$modal.modal("hide"))
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                if (data.message) {
                                    toastr('Error', data.message, 'error');
                                    $('#file-error').text(data.errors.file[0]).show();
                                } else {
                                    toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                                }
                            }
                        });

                    }else{
                        toastr('Error',"{{ __('You have to give a title to your event!')}}", 'error')
                    }
                }), l.$calendarObj.fullCalendar("unselect")
            }, t.prototype.enableDrag = function () {
                // console.log('enableDrag');
                e(this.$event).each(function () {
                    var t = {title: e.trim(e(this).text())};
                    e(this).data("eventObject", t), e(this).draggable({zIndex: 999, revert: !0, revertDuration: 0})
                })
            }, t.prototype.eventDrop = function (e, t, n) {
                // console.log('eventDrop');

                $.ajax({
                    url:'{{route('calendar.updateDate',$currantWorkspace->slug)}}',
                    type:'PUT',
                    data:{id:e.id,allDay:(e.allDay)?1:0,start:e.start.format('YYYY-MM-DD HH:mm:ss'),end:(e.end)?e.end.format('YYYY-MM-DD HH:mm:ss'):null,_token:$('meta[name="csrf-token"]').attr('content')},
                    success:function (data) {
                        toastr('Success','{{ __("Event Updated Successfully!")}}','success');
                    },
                    error:function(data){
                        data = data.responseJSON;
                        if(data.message) {
                            toastr('Error', data.message, 'error');
                        }
                        else{
                            toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    }
                });

            },t.prototype.eventResize = function (e, t, n) {
                // console.log('eventResize');

                $.ajax({
                    url:'{{route('calendar.updateDate',$currantWorkspace->slug)}}',
                    type:'PUT',
                    data:{id:e.id,allDay:(e.allDay)?1:0,start:e.start.format('YYYY-MM-DD HH:mm:ss'),end:(e.end)?e.end.format('YYYY-MM-DD HH:mm:ss'):null,_token:$('meta[name="csrf-token"]').attr('content')},
                    success:function (data) {
                        toastr('Success','{{ __("Event Updated Successfully!")}}','success');
                    },
                    error:function(data){
                        data = data.responseJSON;
                        if(data.message) {
                            toastr('Error', data.message, 'error');
                        }
                        else{
                            toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    }
                });

            }, t.prototype.init = function () {
                this.enableDrag();
                var t = new Date, n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),l = this;

                l.$calendarObj = l.$calendar.fullCalendar({
                    slotDuration: "00:30:00",
                    minTime: "08:00:00",
                    maxTime: "21:00:00",
                    defaultView: "month",
                    handleWindowResize: !0,
                    height: e(window).height() - 200,
                    header: {left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay"},
                    events:  function(start, end, timezone, callback) {

                        // AJAX CALL
                        $.ajax({
                            url:'{{route('calendar.getJson',$currantWorkspace->slug)}}',
                            type:'POST',
                            data:{start:start.format('YYYY-MM-DD HH:mm:ss'),end:end.format('YYYY-MM-DD HH:mm:ss'),_token:$('meta[name="csrf-token"]').attr('content')},
                            success:function (data) {
                                var a = [];
                                data = JSON.parse(data);
                                $(data).each(function (index,dt) {
                                    a.push({id:dt.id,title:dt.title,start:new Date(dt.start),end:(dt.end)?new Date(dt.end):false,allDay:dt.allDay,className:dt.className});
                                });
                                callback(a);
                            },
                            error:function(data){
                                data = data.responseJSON;
                                if(data.message) {
                                    toastr('Error', data.message, 'error');
                                }
                                else{
                                    toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                                }
                            }
                        });

                    },
                    editable: !0,
                    droppable: !0,
                    eventLimit: !0,
                    selectable: !0,
                    drop: function (t) {
                        l.onDrop(e(this), t)
                    },
                    select: function (e, t, n) {
                        l.onSelect(e, t, n)
                    },
                    eventClick: function (e, t, n) {
                        l.onEventClick(e, t, n)
                    },
                    eventDrop:function (e, t, n){
                        l.eventDrop(e, t, n);
                    },
                    eventResize:function (e, t, n){
                        l.eventResize(e, t, n);
                    }
                }), this.$saveCategoryBtn.on("click", function () {
                    // console.log('saveCategoryBtn');
                    var e = l.$categoryForm.find("input[name='category-name']").val(),
                        t = l.$categoryForm.find("select[name='category-color']").val();
                        if(null !== e && 0 != e.length) {
                            $.ajax({
                                url: '{{route('event.store',$currantWorkspace->slug)}}',
                                type: 'POST',
                                data: {title: e, className: t, _token: $('meta[name="csrf-token"]').attr('content')},
                                success: function (data) {
                                    $("#addEvent").trigger("reset");
                                    toastr('Success', '{{ __("Event Added Successfully!")}}', 'success');
                                    data = JSON.parse(data);
                                    (l.$extEvents.append('<div class="external-event bg-' + t + '" data-event-id="'+data.id+'" data-class="bg-' + t + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>' + e + "</div>"), l.enableDrag())
                                },
                                error: function (data) {
                                    data = data.responseJSON;
                                    if (data.message) {
                                        toastr('Error', data.message, 'error');
                                        $('#file-error').text(data.errors.file[0]).show();
                                    } else {
                                        toastr('Error', '{{ __("Some Thing Is Wrong!")}}', 'error');
                                    }
                                }
                            });

                        }
                        else{
                            toastr('Error',"{{ __('You have to give a title to your event!')}}", 'error')
                        }
                });

                // l.$calendarObj.setOption('events',a);

            }, e.CalendarApp = new t, e.CalendarApp.Constructor = t
        }(window.jQuery), function (e) {
            "use strict";
            e.CalendarApp.init()
        }(window.jQuery);
    </script>
    <!-- end demo js-->
@endpush
@endif