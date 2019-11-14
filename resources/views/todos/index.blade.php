@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Todo')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if($currantWorkspace)


    <div class="row">
        <div class="col-lg-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mb-3">{{ __('Todo')}}</h4>

                    <div class="todoapp">
                        <form name="todo-form" id="todo-form" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="todo-input-text" name="todo-input-text" class="form-control"
                                           placeholder="{{ __('Add new todo')}}" required>
                                    <div class="invalid-feedback">
                                        {{ __('Please enter your task name')}}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn-primary btn-md btn-block btn waves-effect waves-light" type="submit" id="todo-btn-submit">{{ __('Add')}}</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            <div class="col">
                                <h5 id="todo-message"><span id="todo-remaining"></span> {{ __('of')}} <span id="todo-total"></span> {{ __('remaining')}}</h5>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="float-right btn btn-light btn-sm" id="btn-archive">{{ __('Archive')}}</a>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush slimscroll todo-list" style="max-height: 100%" id="todo-list"></ul>
                    </div> <!-- end .todoapp-->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->

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
@push('scripts')
    <script>
        !function (t) {
            "use strict";
            var o = function () {
                this.$body = t("body"), this.$todoContainer = t("#todo-container"), this.$todoMessage = t("#todo-message"), this.$todoRemaining = t("#todo-remaining"), this.$todoTotal = t("#todo-total"), this.$archiveBtn = t("#btn-archive"), this.$todoList = t("#todo-list"), this.$todoDonechk = ".todo-done", this.$todoForm = t("#todo-form"), this.$todoInput = t("#todo-input-text"), this.$todoBtn = t("#todo-btn-submit"), window.$todoData = JSON.parse('{!! addslashes($todos) !!}'), this.$todoCompletedData = [], this.$todoUnCompletedData = []
            };
            o.prototype.markTodo = function (t, o) {
                $.ajax({
                    url: '{{route('todos.update',$currantWorkspace->slug)}}',
                    type: 'PUT',
                    data: {"id":t,"done":o,"_token":$('meta[name="csrf-token"]').attr('content')},
                    success: function(data){}
                });
                for (var e = 0; e < window.$todoData.length; e++) window.$todoData[e].id == t && (window.$todoData[e].done = o)
            }, o.prototype.addTodo = function (t) {
                var todo;
                $.post('{{route('todos.store',$currantWorkspace->slug)}}',{"text":t,"done":0,"_token":$('meta[name="csrf-token"]').attr('content')},function(data){
                    todo = JSON.parse(data);
                    window.$todoData.push({id: todo.id, text: todo.text, done: todo.done}), o.prototype.generate()
                });
            }, o.prototype.archives = function () {
                this.$todoUnCompletedData = [];
                for (var t = 0; t < window.$todoData.length; t++) {
                    var o = window.$todoData[t];
                    1 == o.done ? this.$todoCompletedData.push(o) : this.$todoUnCompletedData.push(o)
                }
                $.ajax({
                    url: '{{route('todos.destroy',$currantWorkspace->slug)}}',
                    type: 'DELETE',
                    data: {"archives":this.$todoCompletedData,"_token":$('meta[name="csrf-token"]').attr('content')},
                    success: function(data){}
                });
                window.$todoData = [], window.$todoData = [].concat(this.$todoUnCompletedData), this.generate()
            }, o.prototype.generate = function () {
                $("#todo-list").html("");
                for (var t = 0, o = 0; o < window.$todoData.length; o++) {
                    var e = window.$todoData[o];
                    1 == e.done ? $("#todo-list").prepend('<li class="list-group-item border-0 pl-0"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input todo-done" id="' + e.id + '" checked><label class="custom-control-label" for="' + e.id + '"><s>' + e.text + "</s></label></div></li>") : (t += 1, $("#todo-list").prepend('<li class="list-group-item border-0 pl-0"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input todo-done" id="' + e.id + '"><label class="custom-control-label" for="' + e.id + '">' + e.text + "</label></div></li>"))
                }
                $("#todo-total").text(window.$todoData.length), $("#todo-remaining").text(t)
            }, o.prototype.init = function () {
                var o = this;
                this.generate(), this.$archiveBtn.on("click", function (t) {
                    return t.preventDefault(), o.archives(), 0
                }), t(document).on("change", this.$todoDonechk, function () {
                    this.checked ? o.markTodo(t(this).attr("id"), 1) : o.markTodo(t(this).attr("id"), 0), o.generate()
                }), this.$todoForm.on("submit", function (t) {
                    return t.preventDefault(), "" == o.$todoInput.val() || void 0 === o.$todoInput.val() || null == o.$todoInput.val() ? (o.$todoInput.focus(), 0) : (o.addTodo(o.$todoInput.val()), 1)
                })
            }, t.TodoApp = new o, t.TodoApp.Constructor = o
        }(window.jQuery), function (t) {
            "use strict";
            t.TodoApp.init()
        }(window.jQuery);
    </script>
@endpush
@endif