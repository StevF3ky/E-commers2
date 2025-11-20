<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Beliin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: sans-serif; background-color: #F4F2EE; }</style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md border border-gray-200">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Masukkan Kode OTP</h2>
            <p class="text-sm text-gray-600 mt-2">
                Kode OTP telah dikirim ke email: <br>
                <span class="font-semibold text-blue-600">{{ session('email') }}</span>
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.otp.check') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Kode OTP (6 Digit)</label>
                <input id="otp" class="block mt-1 w-full text-center text-2xl tracking-widest rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 border" 
                       type="text" name="otp" required autofocus maxlength="6" placeholder="123456" />
                
                @error('otp')
                    <span class="text-red-500 text-sm mt-2 block bg-red-50 p-2 rounded border border-red-200">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    Verifikasi & Lanjut
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-800 underline bg-transparent border-none cursor-pointer">
                    Kirim Ulang OTP
                </button>
            </form>
        </div>
    </div>

</body>
</html>