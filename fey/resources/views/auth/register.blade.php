@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #2e2e2e; /* Dark background */
    }
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .register-card {
        background-color: #6183af; /* Soft blue */
        color: white;
        padding: 2rem;
        border-radius: 15px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
    .register-card h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: bold;
        color: white;
    }
    .form-control {
        background-color: #a3bcd5; /* Soft light blue */
        color: #2e2e2e;
        border: 1px solid #8fa6bf;
        border-radius: 10px;
    }
    .form-control:focus {
        background-color: #dfe6ed;
        color: #2e2e2e;
        border-color: #7695b8;
        box-shadow: none;
    }
    .btn-primary {
        background-color: #2e2e2e;
        color: white;
        border: none;
        width: 100%;
        border-radius: 10px;
    }
    .btn-primary:hover {
        background-color: #444444;
    }
    label {
        color: white;
    }
    .invalid-feedback {
        color: #ffcccc;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <h2>{{ __('Register') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" value="{{ old('name') }}" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" 
                    class="form-control" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
