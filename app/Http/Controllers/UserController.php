<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;




// Class untuk mengatur user
class UserController extends Controller
{

    // Method untuk menampilkan halaman index users
    public function index(Request $request)
    {
        $totalAdmin = User::where('roles', 'ADMIN')->count();
        $totalStaff = User::where('roles', 'STAFF')->count();
        $totalUser = User::where('roles', 'USER')->count();

        // Menampilkan semua user
        $users = User::query()

            // Filter berdasarkan nama
            ->when($request->input('name'), function ($query, $name) {
                // Mencari nama yang sesuai dengan nama yang diinput
                return $query->where('name', 'like', '%' . $name . '%');
            })

            // Filter berdasarkan role
            ->when($request->input('role'), function ($query, $role) {
                // Mencari role yang sesuai dengan role yang diinput
                return $query->where('roles', $role);
            })

            // Menampilkan dalam order id DESC
            ->orderBy('id', 'desc')

            // Menampilkan dalam bentuk pagination
            ->simplePaginate(5);

        // Menampilkan view users.index dan memberikan data users
        return view('pages.users.index', compact('users', 'totalAdmin', 'totalUser', 'totalStaff'));
    }

    // Method untuk menampilkan halaman create user
    public function create()
    {
        // Menampilkan view users.create
        return view('pages.users.create');
    }

    // Method untuk menginput data user
    public function store(StoreUserRequest $request)
    {
        // Mendapatkan data yang diinput
        $data = $request->all();

        // Membuat password dengan menggunakan Hash
        $data['password'] = Hash::make($request->password);

        // Menyimpan data user
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'roles' => $data['roles'],
        ]);

        // Redirect ke halaman index user
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    // Method untuk mengedit data user
    public function edit($id)
    {
        // Mendapatkan data user berdasarkan id
        $user = User::findOrFail($id);

        if(request()->ajax()) {
            return response()->json($user);
        }

        // Menampilkan view users.edit dan memberikan data user
        return view('pages.users.edit', compact('user'));
    }

    // Method untuk mengupdate data user
    public function update(UpdateUserRequest $request, User $user)
    {
        // Mendapatkan data yang diinput
        $data = $request->validated();


        // Hapus password dari array agar tidak ikut di-update
        unset($data['password']);

        // Update user
        $user->update($data);

        // Redirect ke halaman index user
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Method untuk menghapus data user
    public function destroy($id)
    {
        // Mendapatkan data user berdasarkan id
        $user = User::findOrFail($id);

        // Menghapus data user
        $user->delete();

        // Redirect ke halaman index user
        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }

    // Method untuk menampilkan detail user
    public function show($id)
    {
        // Mendapatkan data user berdasarkan id
        $user = User::findOrFail($id);

        // Menampilkan view users.show dan memberikan data user
        return view('pages.users.show', compact('user'));
    }

    // Method untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

