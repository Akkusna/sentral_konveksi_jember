<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_color',
        'code_color',
    ];

    protected $table = 'color';

    public function produkColor()
    {
        return $this->hasMany(ProdukColor::class);
    }

    public function pesananColor()
    {
        return $this->hasMany(PesananColor::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
