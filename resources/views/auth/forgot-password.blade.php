<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Beliin</title>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: sans-serif; background-color: #F4F2EE; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md border border-gray-200">
        
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
            <p class="text-sm text-gray-600 mt-2">
                Mengirimkan kode OTP untuk mereset password.
            </p>
        </div>

        
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 p-3 rounded-lg border border-green-200">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border" 
                       type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" />
                
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Kirim Kode OTP
                </button>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Kembali ke Login</a>
            </div>
        </form>
    </div>

</body>
</html>