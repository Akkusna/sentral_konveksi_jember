<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'ukuran',
    ];

    protected $table = 'ukuran';

    public function produkUkuran()
    {
        return $this->hasMany(ProdukUkuran::class);
    }

    public function pesananUkuran()
    {
        return $this->hasMany(PesananUkuran::class);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
