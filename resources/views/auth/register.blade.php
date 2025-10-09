<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="wrapper">
        <form method="POST" action="{{ route('register') }}">
            @csrf 
            <h1>Register</h1>
            
            {{-- Input Username/Name --}}
            <div class="input-box">
                <input type="text" id="username" name="name" placeholder="Username" value="{{ old('name') }}" required autofocus>
                <ion-icon name="person-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'name' --}}
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

            {{-- Input Email --}}
            <div class="input-box">
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <ion-icon name="mail-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'email' --}}
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            {{-- Input Password --}}
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <ion-icon name="lock-closed-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'password' --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            {{-- Input Confirm Password --}}
            <div class="input-box">
                <input type="password" id="confirmpassword" name="password_confirmation" placeholder="Confirm Password" required>
                <ion-icon name="lock-closed-outline"></ion-icon>
            </div>
            {{-- Menampilkan Error untuk 'password_confirmation' --}}
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            
            <button type="submit" class="btnregister">Register</button>
            
            <div class="register-link">
                <p>Already have an account? <a href="{{ route('login') }}">Login now</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>