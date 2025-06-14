<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file Blade ini ada di resources/views/auth/login.blade.php
    }
    // Register hanya untuk pembeli
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Berikan role "buyer" secara otomatis
        $user->assignRole('customer');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'customer'
            ],
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 201);
    }

    // Login untuk peneliti & pembeli
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Email atau password salah.'], 401);
            }
    
            if (!$user->roles->isNotEmpty()) {
                return response()->json(['message' => 'Akun ini belum memiliki role.'], 403);
            }
    
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->roles->pluck('name')->first(),
                ],
                'token' => $user->createToken('auth_token')->plainTextToken
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server', 'error' => $e->getMessage()], 500);
        }
    }
    

    // Logout
    public function logout(Request $request)
    {
        // Hapus token saat ini (logout satu perangkat)
        $request->user()->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Logout berhasil'], 200);
    }
    
}
