<?php

namespace Avalon\LrvLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Avalon\LrvLogin\Services\EmailService;

class AuthController
{
    public function showRegisterForm()
    {
        return view('lrv_login::auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 200);
    }

    public function showLoginForm()
    {
        if(!Auth::check()){
            return view('lrv_login::auth.login');
        }else{
            return response()->json(['message' => 'User Already Logged In'], 201);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => 'User Logged In successfully'], 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otp = rand(100000, 999999); // Generate OTP
        $user->update(['otp' => $otp]);

        // Send OTP via Email
        (new EmailService)->sendOtp($user->email, $otp);

        return response()->json(['message' => 'OTP sent to your email']);
    }
}
