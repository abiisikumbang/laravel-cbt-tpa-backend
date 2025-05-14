<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use iluminate\http\StoreUserRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        ]);
/** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }
/** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('success', 'Password berhasil diganti.');
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
    ]);

    /** @var \App\Models\User $user */
    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return back()->with('success_profile', 'Profil berhasil diperbarui!');
}


}
