<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::OrderByDesc('id')->where('is_admin', '0')->get();
        return view('dashboard.user', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'notelp' => 'required',
            'email' => 'required',
        ]);

        $user = Auth::user()->id;

        $users = User::findOrFail($user);

        $users->update($validateData);

        return redirect()->back()->with('message', 'data berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $validateData = $request->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'confirm_password.same' => 'Konfirmasi password tidak cocok dengan password baru.',
        ]);

        $user = Auth::user();

        $hashedPassword = Hash::make($validateData['new_password']);

        $user->password = $hashedPassword;
        $user->save();

        return redirect()->back()->with('message', 'Kata sandi berhasil diperbarui');
    }
}
