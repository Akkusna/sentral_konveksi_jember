<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], $messages);

        $validator->validate();

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $user = \App\Models\User::where('email', $email)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'Email tidak terdaftar.'
                ]);
            } else {
                throw ValidationException::withMessages([
                    'password' => 'Password salah.'
                ]);
            }
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->is_admin == 1) {
            return redirect()->route('dashboard')->with('message', 'Berhasil Login');
        } else {
            return redirect()->route('home')->with('message', 'Berhasil Login');
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
