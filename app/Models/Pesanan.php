<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'produk_id',
        'pengiriman_id',
        'qty',
        'nota',
        'qr_code',
        'jasa_ekspedisi',
        'harga_ongkir',
        'grand_total',
        'status',
        'bukti',
        'bukti_pelunasan',
        'pengiriman',
        'status_pembayaran',
        'detail_pesanan',
        'detail_alamat',
    ];

    protected $table = 'pesanan';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'pengiriman_id');
    }

    public function transaksiKeluar(): HasMany
    {
        return $this->hasMany(TransaksiKeluar::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function detailPesananBahanBaku()
    {
        return $this->hasMany(PesananBahanBaku::class);
    }
}
