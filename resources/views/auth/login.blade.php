<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Login</title>

    @vite(['resources/css/app.css', 'resources/css/IndexAuth.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    
    <div class="wrapper">
       <form method="POST" action="{{ route('login') }}">
        @csrf 
           <h1>Login</h1>
           
           
            <div class="input-box">
                <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <ion-icon name="person-outline"></ion-icon>
            </div>
           
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
           
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <ion-icon name="lock-closed-outline"></ion-icon>
            </div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
            <div class="remember-forgot">
               
                <label>
                    <input type="checkbox" name="remember">Remember me
                </label>
                
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            
            <button type="submit" class="btnlogin">Login</button>
            
            <div class="register-link">
                <p>
                    Don't have an account? <a href="{{ route('register') }}">Register now</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>