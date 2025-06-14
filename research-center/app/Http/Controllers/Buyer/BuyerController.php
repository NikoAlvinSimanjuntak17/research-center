<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class BuyerController extends Controller
{
    public function registerBuyer(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        // Buat akun user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Berikan role "buyer"
        $user->addRole('buyer');

        return redirect('/login'); // Sesuaikan dengan lokasi blade-mu
    }
    
    public function showRegisterForm()
    {
        return view('auth.register'); // Sesuaikan dengan lokasi blade-mu
    }
    

    public function loginBuyer(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Login gagal.'], 401);
        }

        $user = Auth::user();

        // Pastikan user adalah buyer
        if (!$user->hasRole('buyer')) {
            return response()->json(['message' => 'Anda bukan pembeli.'], 403);
        }

        // Buat token untuk API authentication
        $token = $user->createToken('buyer-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logoutBuyer()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil.']);
    }
}
