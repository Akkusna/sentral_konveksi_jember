<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
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
use Maatwebsite\Excel\Facades\Excel;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.color', 'detailPesanan.ukuran', 'produk', 'detailPesananBahanBaku'])->orderByDesc('id')->get();
        $bahan = BahanBaku::all();
        return view('dashboard.pemesanan', compact('pesanan', 'bahan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'status_pembayaran' => 'required',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status === 'selesai') {
            return back()->withErrors('Pesanan telah selesai tidak dapat melakukan perubahan');
        }

        if ($pesanan->status === 'lunas') {
            return back()->withErrors('Pesanan telah dibayar lunas tidak dapat melakukan perubahan');
        }
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
        $totalHargaProduk = $pesanan->produk->harga * $pesanan->qty;

        $extraCharges = [];
        $biayaTambahan = 0;

        $ukuranXXLCharge = 0;
        $lenganPanjangCharge = 0;

        foreach ($pesanan->detailPesanan as $detail) {
            if ($detail->ukuran->ukuran === 'XXL') {
                $ukuranXXLCharge += 7000 * $detail->qty;
            }
            if ($detail->ukuran_lengan === 'panjang') {
                $lenganPanjangCharge += 10000 * $detail->qty;
            }
        }

        if ($ukuranXXLCharge > 0) {
            $extraCharges[] = [
                'description' => 'Biaya Ukuran XXL',
                'amount' => $ukuranXXLCharge
            ];
            $biayaTambahan += $ukuranXXLCharge;
        }

        if ($lenganPanjangCharge > 0) {
            $extraCharges[] = [
                'description' => 'Biaya Lengan Panjang',
                'amount' => $lenganPanjangCharge
            ];
            $biayaTambahan += $lenganPanjangCharge;
        }

        $pdf = FacadePdf::loadView('dashboard.nota-pdf', compact('pesanan', 'extraCharges', 'biayaTambahan'));
        $pdf->setPaper(array(0, 0, 298, 520), 'portrait');

        $timestamp = Carbon::now()->format('YmdHis');

        $pdfFileName = 'nota_' . $pesanan->id . '_' . $timestamp . '.pdf';
        $pdfPath = public_path('nota/' . $pdfFileName);
        $pdf->save($pdfPath);

        $qrCodeFileName = 'qrcodes/' . $pesanan->id . '_' . $timestamp . '.png';
        $qrCodePath = public_path('nota/' . $qrCodeFileName);

        $pdfUrl = url('nota/' . $pdfFileName);

        $qrCode = new QrCodeQrCode($pdfUrl);
        $qrCode->setSize(400);
        $qrCode->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $result->saveToFile($qrCodePath);

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

    public function laporan_pesanan()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.color', 'detailPesanan.ukuran', 'produk'])->orderByDesc('id')->get();
        return view('dashboard.laporan-pesanan', compact('pesanan'));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        return Excel::download(new OrdersExport($startDate, $endDate), 'pesanan.xlsx');
    }
}
