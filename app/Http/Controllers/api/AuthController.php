<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 *
 * Kelas ini digunakan untuk mengatur proses login dan registrasi
 *
 * @package App\Http\Controllers\api
 */
class AuthController extends Controller
{
    /**
     * Fungsi login
     *
     * Fungsi ini digunakan untuk melakukan proses login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password tidak sesuai
        if(!$user || !Hash::check($request->password, $user->password)){
            // Kembalikan respon error 401
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }
        // Buat token baru untuk user
        $token = $user->createToken('flutter_token')->plainTextToken;
       // Kembalikan respon dengan token dan data user
       return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
           'user' => $user
       ], 200); // ← Berhasil login
    }


    /**
     * Fungsi register
     *
     * Fungsi ini digunakan untuk melakukan proses registrasi
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)

    {
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),

        ]);

        // Buat token baru untuk user
        $token = $user->createToken('flutter_token')->plainTextToken;

        // Kembalikan respon dengan token dan data user
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ],201);
    }
}

