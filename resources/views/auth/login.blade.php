<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
            {{ __('Whoops! Something went wrong.') }}
        </div>
    @endif
    
    <div class="wrapper">
       <form method="POST" action="{{ route('login') }}">
        @csrf 
           <h1>Login</h1>
           
            {{-- Input Email --}}
            <div class="input-box">
                <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'email' --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
            {{-- Input Password --}}
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <ion-icon name="lock-closed-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'password' --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
            <div class="remember-forgot">
                {{-- Checkbox Remember Me --}}
                <label>
                    <input type="checkbox" name="remember">Remember me
                </label>
                {{-- Link Forgot Password --}}
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
</x-guest-layout>