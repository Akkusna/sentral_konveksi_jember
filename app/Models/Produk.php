<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kategori_id',
        'nama',
        'image',
        'deskripsi',
        'harga',
    ];

    protected $table = 'produk';

    public function produkColor()
    {
        return $this->hasMany(ProdukColor::class);
    }

    public function produkUkuran()
    {
        return $this->hasMany(ProdukUkuran::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
