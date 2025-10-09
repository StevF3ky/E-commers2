<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Forgot Password</title>

    @vite(['resources/css/app.css', 'resources/css/IndexAuth.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    

    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="wrapper">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf 
            <h1>Forgot Password</h1>
            <p style="text-align:center; margin-bottom: 20px;">Enter your email to reset your password</p>

            
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                <ion-icon name="mail-outline"></ion-icon>
            </div>
            
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <button type="submit" class="btnreset">Send Reset Link</button>

            <div class="register-link">
                <p>Remembered your password? <a href="{{ route('login') }}">Login now</a></p>
            </div>
        </form>
    </div>
</body>
</html>