<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengiriman extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'status',
        'tanggal_pengiriman',
        'tanggal_tiba',
        'alamat_tujuan',
        'alamat',
        'estimasi',
    ];

    protected $table = 'pengiriman';

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
