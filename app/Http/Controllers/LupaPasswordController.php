<?php

namespace App\Http\Controllers;

use App\Mail\SomeMailableClass;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LupaPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->firstOrFail();

        $randomString = Str::random(40);

        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $randomString, 'created_at' => now()]
        );

        Mail::to($request->email)->send(new SomeMailableClass($randomString));

        return redirect()->back()->with('message', 'Berhasil mengirim link reset password ke email anda.');
    }

    public function validasi_forgot_password(Request $request, $token)
    {
        $getToken = PasswordReset::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('login')->with('error', 'Token tidak valid');
        }

        return view('auth.validasi-password', compact('token'));
    }

    public function validasi_forgot_password_act(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8'
        ]);

        $token = PasswordReset::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('login')->with('error', 'Token tidak valid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('failed', 'Email tidak terdaftar di database');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $token->delete();

        return redirect()->route('login')->with('message', 'Password berhasil direset');
    }
}
