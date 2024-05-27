<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukUkuran extends Model
{
    use HasFactory;
    protected $fillable = [
        'produk_id',
        'ukuran_id',
    ];

    protected $table = 'detail_produk_ukuran';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
}
