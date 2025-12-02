@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #2e2e2e; /* Dark grey background */
    }
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background-color: #6183af; /* Main soft blue */
        color: white;
        padding: 2rem;
        border-radius: 15px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
    .login-card h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: bold;
        color: white;
    }
    .form-control {
        background-color: #a3bcd5; /* Soft pastel blue */
        color: #2e2e2e;
        border: 1px solid #8fa6bf;
        border-radius: 10px;
    }
    .form-control:focus {
        background-color: #dfe6ed; /* Light gray-blue */
        color: #2e2e2e;
        border-color: #7695b8;
        box-shadow: none;
    }
    .btn-primary {
        background-color: #2e2e2e; /* Dark grey */
        color: white;
        border: none;
        width: 100%;
        border-radius: 10px;
    }
    .btn-primary:hover {
        background-color: #444444;
    }
    .form-check-label, label {
        color: white;
    }
    .invalid-feedback {
        color: #ffcccc;
    }
    a.btn-link {
        color: #f0f8ff;
        display: block;
        margin-top: 10px;
        text-align: center;
    }
    a.btn-link:hover {
        color: #ffffff;
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <h2>{{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <a class="btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
</div>
@endsection
