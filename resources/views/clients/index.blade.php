@extends('layouts.main')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Clients')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if($currantWorkspace)
        @if($currantWorkspace->creater->id == Auth::user()->id)
        <div class="row mb-2">
            <div class="col-sm-4">
                <button type="button" class="btn btn-danger btn-rounded mb-3" data-ajax-popup="true" data-size="lg" data-title="{{ __('Add Client') }}" data-url="{{route('clients.create',$currantWorkspace->slug)}}">
                    <i class="mdi mdi-plus"></i> {{ __('Add Client') }}
                </button>
            </div>
        </div>
        @endif
        <div class="row">
            @foreach ($clients as $client)
            <div class="col-lg-4 col-md-4 animated">
                <div class="card">
                    <div class="card-body">
                        <span class="float-left mr-4">
                            <img avatar="{{ $client->name }}" alt="" class="rounded-circle img-thumbnail">
                        </span>
                        <div class="media-body">
                            <h4 class="mt-1">{{$client->name}}</h4>
                            <p class="font-13 mb-0">{{$client->email}}</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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