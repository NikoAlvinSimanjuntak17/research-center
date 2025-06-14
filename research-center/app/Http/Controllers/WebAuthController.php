<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file Blade ini ada di resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('researcher')) {
                return redirect()->route('researchers.dashboard');
            } else {
                return redirect('/'); // Default untuk user biasa
            }
        }
        
        return redirect()->back()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Logout berhasil');
    }
    
    public function showProfile()
    {
        $user = auth()->user();
        
        try {
            // Ambil project yang sedang berjalan
            $ongoingProjects = $user->projects()
                ->where('progress_status', 'in_progress')
                ->get();
        } catch (\Exception $e) {
            $ongoingProjects = collect();
        }
        
        try {
            // Ambil project yang sudah selesai
            $completedProjects = $user->projects()
                ->where('progress_status', 'completed')
                ->get();
        } catch (\Exception $e) {
            $completedProjects = collect();
        }
        
        try {
            // Ambil publikasi dari project yang user ikuti
            $projectIds = $user->projects()->pluck('id');
            $publications = Publication::whereIn('project_id', $projectIds)->get();
        } catch (\Exception $e) {
            $publications = collect();
        }
        
        // Pastikan semua variabel bukan null
        $ongoingProjects = $ongoingProjects ?? collect();
        $completedProjects = $completedProjects ?? collect();
        $publications = $publications ?? collect();
        
        return view('auth.profile', compact('user', 'ongoingProjects', 'completedProjects', 'publications'));
    }
}

