<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->input('role'), function ($query, $role) {
                return $query->where('roles', $role);
            })
            ->orderBy('id', 'desc')
            ->simplePaginate(5);

        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>$data['password'],
            'phone' => $data['phone'],
            'roles' => $data['roles'],
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $data = $request->validated();
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');

    // // Verifikasi password sekarang
    // if (!Hash::check($request->password, $user->password)) {
    //     return back()->withErrors(['password' => 'Password yang dimasukkan salah. Perubahan tidak disimpan.'])->withInput();
    // }

    // // Hapus password dari array agar tidak ikut di-update
    // unset($data['password']);

    // // Update user
    // $user->update($data);

    // return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

    // public function update(UpdateUserRequest $request, User $user)
    // {
    //     $data = $request->validated();
    //     $user->update($data);
    //     return redirect()->route('users.index')->with('success', 'User updated successfully.');
    // }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.users.show', compact('user'));
    }
}
