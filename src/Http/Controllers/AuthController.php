<?php

namespace Avalon\LrvLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function showRegisterForm()
    {
        return view('lrv_login::auth.register');
    }

    public function register(Request $request)
    {
        // Validation and registration logic
    }

    public function showLoginForm()
    {
        return view('lrv_login::auth.login');
    }

    public function login(Request $request)
    {
        // Validation and login logic
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
