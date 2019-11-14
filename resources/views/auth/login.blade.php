@extends('layouts.auth')

@section('content')


    <!-- title-->
    <h4 class="mt-0">{{ __('Sign In') }}</h4>
    <p class="text-muted mb-4">{{ __('Enter your username and password to access account.') }}</p>

    <!-- form -->
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" id="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="{{ __('Enter Your Username') }}">
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <a href="{{ route('password.request') }}" class="text-muted float-right"><small>{{ __('Forgot your password?') }}</small></a>
            <label for="password">{{ __('Password') }}</label>
            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" id="password" placeholder="{{ __('Enter Your Password') }}">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="checkbox-signin">{{ __('Remember Me') }}</label>
            </div>
        </div>
        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-login"></i> {{ __('Log in') }} </button>
        </div>
    </form>
    <!-- end form-->

    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">{{ __('Don\'t have an account?') }} <a href="{{ route('register') }}" class="text-muted ml-1"><b>{{ __('Sign Up') }}</b></a></p>
    </footer>

@endsection
