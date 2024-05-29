<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
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
        return Pesanan::with(['user', 'produk', 'detailPesanan.color', 'detailPesanan.ukuran'])
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
            'Nama Pelanggan',
            'Pesanan',
            'Detail Pesanan',
            'Total Harga',
            'Tanggal Pesan',
        ];
    }

    public function map($order): array
    {
        $details = $order->detailPesanan->map(function ($detail) {
            return "{$detail->color->name_color} / {$detail->ukuran->ukuran} x {$detail->qty}";
        })->implode("\n");

        return [
            $order->id,
            $order->user->name,
            "{$order->produk->nama} x {$order->qty}",
            $details,
            'Rp. ' . number_format($order->produk->harga * $order->qty, 0, ',', '.'),
            \Carbon\Carbon::parse($order->created_at)->format('d F Y'),
        ];
    }
}
