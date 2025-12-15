<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect berdasarkan role
        if (auth()->check()) {
            $user = auth()->user();
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'operator':
                    return redirect()->route('operator.dashboard');
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    return redirect()->route('login');
            }
        }
        
        // Jika belum login, redirect ke login
        return redirect()->route('login');
    }
}