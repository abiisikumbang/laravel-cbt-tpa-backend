<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.users.profile.index', compact('user'));
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

        if (!Hash::check((string) $request->current_password, (string) $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }

        if ($request->current_password === $request->new_password) {
            return back()->with('error', 'Password baru tidak boleh sama dengan password saat ini.');
        }

        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diganti.');
    }
}
