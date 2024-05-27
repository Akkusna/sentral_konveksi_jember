<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::OrderByDesc('id')->get();
        return view('dashboard.colors', compact('colors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_color' => 'required',
            'code_color' => 'required',
        ]);

        Color::create($validatedData);
        return redirect()->route('colors')->with('message', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('colors')->with('message', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_color' => 'required',
            'code_color' => 'required',
        ]);

        $color = Color::findOrFail($id);
        $color->update($validatedData);
        return redirect()->route('colors')->with('message', 'Data berhasil diperbarui.');
    }
}
