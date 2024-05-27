<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\BahanBaku;
use App\Models\DetailPesanan;
use App\Models\PesananBahanBaku;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Endroid\QrCode\QrCode as QrCodeQrCode;
use Endroid\QrCode\Writer\PngWriter;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.color', 'detailPesanan.ukuran', 'detailPesanan.bahanBaku.transaksiKeluar', 'produk', 'detailPesananBahanBaku'])->orderByDesc('id')->get();
        $bahan = BahanBaku::all();
        return view('dashboard.pemesanan', compact('pesanan', 'bahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'nullable',
    //         'status_pembayaran' => 'nullable',
    //         'bahan_baku_id.*' => 'nullable|exists:bahan_baku,id',
    //         'qty.*' => 'nullable|numeric|min:1'
    //     ]);

    //     $pesanan = Pesanan::findOrFail($id);

    //     $pesanan->update([
    //         'status' => $request->status,
    //         'status_pembayaran' => $request->status_pembayaran,
    //     ]);

    //     $bahanBakuIds = $request->input('bahan_baku_id', []);
    //     $qtys = $request->input('qty', []);

    //     foreach ($bahanBakuIds as $index => $bahanBakuId) {
    //         $qty = $qtys[$index];
    //         $bahanBaku = BahanBaku::findOrFail($bahanBakuId);

    //         // Cek jika qty tidak cukup
    //         if ($bahanBaku->qty < $qty) {
    //             return redirect()->route('pesanan')->with('error', 'Jumlah bahan baku tidak mencukupi untuk bahan baku ID: ' . $bahanBakuId);
    //         }

    //         // Cek apakah sudah ada record di transaksi keluar dengan pesanan_id dan bahan_baku_id
    //         $transaksiKeluar = TransaksiKeluar::where('pesanan_id', $pesanan->id)
    //             ->where('bahan_baku_id', $bahanBakuId)
    //             ->first();

    //         if ($transaksiKeluar) {
    //             // Jika ada, update qty
    //             $transaksiKeluar->update([
    //                 'qty' => $qty,
    //             ]);
    //         } else {
    //             // Jika tidak ada, buat record baru
    //             TransaksiKeluar::create([
    //                 'pesanan_id' => $pesanan->id,
    //                 'bahan_baku_id' => $bahanBakuId,
    //                 'qty' => $qty,
    //             ]);
    //         }

    //         // Perbarui qty bahan baku
    //         $bahanBaku->update([
    //             'qty' => $bahanBaku->qty - $qty,
    //         ]);

    //         // Cek apakah sudah ada record dengan pesanan_id dan bahan_baku_id di detail pesanan
    //         $detailPesanan = DetailPesanan::where('pesanan_id', $pesanan->id)
    //             ->where('bahan_baku_id', $bahanBakuId)
    //             ->first();

    //         if ($detailPesanan) {
    //             // Jika ada, update qty (jika diperlukan) atau tindakan lain yang diperlukan
    //             $detailPesanan->update([
    //                 'qty' => $qty, // Misalkan kita ingin mengupdate qty, sesuaikan dengan logika yang diinginkan
    //             ]);
    //         } else {
    //             // Jika tidak ada, buat record baru
    //             DetailPesanan::create([
    //                 'pesanan_id' => $pesanan->id,
    //                 'bahan_baku_id' => $bahanBakuId,
    //                 // 'qty' => $qty, // Pastikan menambahkan field qty jika diperlukan
    //             ]);
    //         }
    //     }

    //     if ($request->status_pembayaran == 'dp') {
    //         $this->cetakNota($id);
    //     }

    //     return redirect()->route('pesanan')->with('message', 'Data berhasil diupdate');
    // }
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'status_pembayaran' => 'required',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status' => $request->status,
            'status_pembayaran' => $request->status_pembayaran,
        ]);


        if ($request->status_pembayaran == 'dp') {
            $this->cetakNota($id);
        }

        return redirect()->route('pesanan')->with('message', 'Data berhasil diupdate');
    }

    public function cetakNota($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Generate PDF nota
        $pdf = FacadePdf::loadView('dashboard.nota-pdf', compact('pesanan'));
        $pdf->setPaper(array(0, 0, 298, 420), 'portrait'); // A6 in points (105 mm x 148 mm)

        // Generate unique timestamp
        $timestamp = Carbon::now()->format('YmdHis');

        // Generate file paths with timestamp
        $pdfFileName = 'nota_' . $pesanan->id . '_' . $timestamp . '.pdf';
        $pdfPath = public_path('nota/' . $pdfFileName);
        $pdf->save($pdfPath);

        $qrCodeFileName = 'qrcodes/' . $pesanan->id . '_' . $timestamp . '.png';
        $qrCodePath = public_path('nota/' . $qrCodeFileName);

        // Generate the URL to the PDF file
        $pdfUrl = url('nota/' . $pdfFileName);

        // Create the QR code with the URL of the PDF
        $qrCode = new QrCodeQrCode($pdfUrl);
        $qrCode->setSize(400);
        $qrCode->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Save the QR code to the specified path
        $result->saveToFile($qrCodePath);

        // Update pesanan with QR Code path
        $pesanan->update([
            'nota' => $pdfFileName,
            'qr_code' => $qrCodeFileName,
        ]);

        return redirect()->route('pesanan')->with('message', 'Nota telah berhasil dibuat');
    }

    public function storeOrUpdateBahanBaku(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,id',
            'bahan_baku_id' => 'required|array',
            'bahan_baku_id.*' => 'exists:bahan_baku,id',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
        ]);

        $pesananId = $request->input('pesanan_id');
        $bahanBakuIds = $request->input('bahan_baku_id');
        $qtys = $request->input('qty');

        foreach ($bahanBakuIds as $index => $bahanBakuId) {
            $qty = $qtys[$index];

            $pesananBahanBaku = PesananBahanBaku::updateOrCreate(
                [
                    'pesanan_id' => $pesananId,
                    'bahan_baku_id' => $bahanBakuId,
                ],
                [
                    'qty' => $qty,
                ]
            );
        }

        return redirect()->back()->with('message', 'Pesanan Bahan Baku updated successfully!');
    }
}
