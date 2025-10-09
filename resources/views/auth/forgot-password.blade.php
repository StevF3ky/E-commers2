<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="wrapper">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf 
            <h1>Forgot Password</h1>
            <p style="text-align:center; margin-bottom: 20px;">Enter your email to reset your password</p>

            {{-- Input Email --}}
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                <ion-icon name="mail-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'email' --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <button type="submit" class="btnreset">Send Reset Link</button>

            <div class="register-link">
                <p>Remembered your password? <a href="{{ route('login') }}">Login now</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>