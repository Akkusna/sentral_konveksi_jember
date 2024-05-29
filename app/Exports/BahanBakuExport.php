<?php

namespace App\Exports;

use App\Models\BahanBaku;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BahanBakuExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BahanBaku::with(['transaksiMasuk', 'transaksiKeluar'])
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Bahan Baku',
            'Harga per meter',
            'Jumlah Masuk',
            'Total Harga',
            'Jumlah Digunakan',
            'Sisa Bahan',
            'Tanggal Beli',
        ];
    }

    public function map($bahan): array
    {
        return [
            $bahan->id,
            $bahan->nama,
            'Rp. ' . number_format($bahan->harga, 0, ',', '.'),
            $bahan->transaksiMasuk->sum('qty') . ' meter',
            'Rp. ' . number_format($bahan->harga * $bahan->transaksiMasuk->sum('qty'), 0, ',', '.'),
            $bahan->transaksiKeluar->sum('qty') . ' meter',
            $bahan->qty,
            Carbon::parse($bahan->created_at)->format('d F Y'),
        ];
    }
}
