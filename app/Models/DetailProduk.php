<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'color_id',
        'ukuran_id',
    ];

    protected $table = 'detail_produk';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
}
