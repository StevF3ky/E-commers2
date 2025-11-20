<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class OtpResetController extends Controller
{
    
    public function create()
    {
        return view('auth.forgot-password');
    }

    
    public function store(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'exists:users,email']]);

        
        $otp = rand(100000, 999999);
        $email = $request->email;

        
        Cache::put('otp_' . $email, $otp, 300);

        
        Mail::raw("Kode OTP Reset Password Anda adalah: $otp. Kode ini berlaku selama 5 menit.", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Kode OTP Reset Password');
        });

        
        return redirect()->route('password.otp.verify')->with(['email' => $email, 'status' => 'Kode OTP telah dikirim ke email Anda.']);
    }

    
    public function verifyPage()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

   
    public function verifyStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau kadaluarsa.']);
        }

        
        Session::put('allow_reset_password', $request->email);
        
        
        Cache::forget('otp_' . $request->email);

        return redirect()->route('password.reset.form');
    }

  
    public function resetPage()
    {
        
        if (!Session::has('allow_reset_password')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.reset-password-otp');
    }

    
    public function resetStore(Request $request)
    {
        $email = Session::get('allow_reset_password');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        $user = User::where('email', $email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        
        Session::forget('allow_reset_password');

        return redirect()->route('login');
    }
}