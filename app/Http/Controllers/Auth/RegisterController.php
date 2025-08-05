<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        // Validasi otomatis oleh Form Request: StoreUserRequest

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'roles' => $request->roles ?? 'USER', // default ke USER
            'total_points' => 0,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
