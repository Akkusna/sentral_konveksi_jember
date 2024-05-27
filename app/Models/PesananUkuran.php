<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananUkuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'ukuran_id',
        'qty',
    ];

    protected $table = 'detail_pesanan_ukuran';

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
}
