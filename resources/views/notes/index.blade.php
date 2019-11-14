@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Notes')}}</h4>
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
                    <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Note') }}" data-url="{{route('notes.create',$currantWorkspace->slug)}}">
                        <i class="mdi mdi-plus"></i> {{ __('Create Note') }}
                    </button>

                    <div class="row">
                        @foreach($notes as $note)
                        <div class="col-md-4">
                            <div class="card mb-0 mt-3 text-white {{$note->color}}">
                                <div class="card-body">
                                    <div class="card-widgets">
                                        <a href="#" data-ajax-popup="true" data-size="lg" data-title="{{ __('Edit Note') }}" data-url="{{route('notes.edit',[$currantWorkspace->slug,$note->id])}}"><i class="mdi mdi-pencil"></i></a>
                                        <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-{{$note->id}}').submit(): '');"><i class="mdi mdi-trash-can    "></i></a>
                                        <form id="delete-form-{{$note->id}}" action="{{ route('notes.destroy',[$currantWorkspace->slug,$note->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                    <h5 class="card-title mb-0">{{$note->title}}</h5>
                                    <div id="cardCollpase2" class="collapse pt-3 show">
                                        {{$note->text}}
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        @endforeach

                    </div>

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