@extends('layouts.auth')
@section('content')
    <div class="login-form login-signin">
        <div class="mb-10 text-center">
            <img src="{{ asset(config('base.logo.auth')) }}" alt="Image" style="max-width: 300px; max-height: 100px">
        </div>
        <div class="mb-10 mb-lg-15">
            <h1 class="font-size-h1 font-weight-boldest"><small><b>IMS</b> Insurance Management System</small></h1>
            <p class="text-muted font-weight-bold">Masuk untuk melanjutkan</p>
        </div>

        <form class="form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="font-weight-bolder">{{ __('Username / Email') }}</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="{{ __('Masukkan Username / Email') }}" name="username" autofocus>
                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bolder">{{ __('Password') }}</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Masukkan Password') }}" name="password" autocomplete="off" />
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="mr-2"></span>{{ __('Remember Me') }}
                </label>
            </div>

            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary btn-block font-weight-bold my-3 py-3">
                    {{ __('Masuk') }}
                </button>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="w-100 text-center text-dark-50 text-hover-danger my-3 mr-2">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection


