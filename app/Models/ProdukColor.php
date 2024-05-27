<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'color_id',
    ];

    protected $table = 'detail_produk_color';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
