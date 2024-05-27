<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $bank = Bank::OrderByDesc('id')->get();
        return view('dashboard.bank', compact('bank'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'no_rekening' => 'required',
        ]);

        Bank::create($validatedData);
        return redirect()->route('bank')->with('message', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        return redirect()->route('bank')->with('message', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'no_rekening' => 'required',
        ]);

        $bank = Bank::findOrFail($id);
        $bank->update($validatedData);
        return redirect()->route('bank')->with('message', 'Data berhasil diperbarui.');
    }
}
