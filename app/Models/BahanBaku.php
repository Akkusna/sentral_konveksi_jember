<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'qty',
        'total_harga',
    ];

    protected $table = 'bahan_baku';

    public function transaksiMasuk(): HasMany
    {
        return $this->hasMany(TransaksiMasuk::class);
    }
    public function transaksiKeluar(): HasMany
    {
        return $this->hasMany(TransaksiKeluar::class);
    }
    public function detailBahanBaku()
    {
        return $this->hasMany(PesananBahanBaku::class);
    }
}
