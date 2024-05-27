<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
