<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    public function index()
    {
        $ukuran = Ukuran::OrderByDesc('id')->get();
        return view('dashboard.ukuran', compact('ukuran'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ukuran' => 'required',
        ]);

        Ukuran::create($validatedData);
        return redirect()->route('ukuran')->with('message', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $ukuran = Ukuran::findOrFail($id);
        $ukuran->delete();
        return redirect()->route('ukuran')->with('message', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ukuran' => 'required',
        ]);

        $ukuran = Ukuran::findOrFail($id);
        $ukuran->update($validatedData);
        return redirect()->route('ukuran')->with('message', 'Data berhasil diperbarui.');
    }
}
