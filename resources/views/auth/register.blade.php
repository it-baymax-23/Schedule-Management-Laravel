@extends('layouts.auth')

@section('content')

    <!-- title-->
    <h4 class="mt-0">{{ __('Free Sign Up') }}</h4>
    <p class="text-muted mb-4"> {{ __('Don\'t have an account? Create your account, it takes less than a minute') }}</p>

    <!-- form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="fullname">{{ __('Full Name') }}</label>
            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" id="fullname" placeholder="{{ __('Enter Your Name') }}" value="{{ old('name') }}" required autocomplete="name">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="workspace_name">{{ __('Workspace Name') }}</label>
            <input class="form-control @error('workspace_name') is-invalid @enderror" name="workspace" type="text" id="workspace_name" placeholder="{{ __('Enter Workspace Name') }}" value="{{ old('workspace') }}" required autocomplete="workspace">
            @error('company')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input class="form-control @error('username') is-invalid @enderror" name="username" type="text" id="username" placeholder="{{ __('Enter Your Username') }}" value="{{ old('username') }}" required autocomplete="username">
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="emailaddress">{{ __('Email Address') }}</label>
            <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" id="emailaddress" placeholder="{{ __('Enter Your Email') }}" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" required autocomplete="new-password" id="password" placeholder="{{ __('Enter Your Password') }}">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" type="password" required autocomplete="new-password" id="password_confirmation" placeholder="{{ __('Enter Your Password') }}">
        </div>

        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-account-circle"></i> {{ __('Sign Up') }} </button>
        </div>

    </form>
    <!-- end form-->

    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">{{ __('Already Have Account?') }} <a href="{{ route('login') }}" class="text-muted ml-1"><b>{{ __('Log In') }}</b></a></p>
    </footer>
@endsection
