<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomLoginController extends Controller
{
    public function ShowLoginForm(){
        return view('pages.auth.login');
    }
     public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->roles !== 'ADMIN') {
                Auth::logout();

                // Kirim error ke login page
                return back()->withErrors([
                    'email' => 'Kredensial tidak valid/Login hanya untuk Admin.',
                ])->withInput();
            }

            // Redirect ke dashboard
            return redirect()->intended('/home');
        }

        // Jika email/password salah
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
