<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailPesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pesanan_id',
        'ukuran_id',
        'color_id',
        'qty',
        'ukuran_lengan',
    ];

    protected $table = 'detail_pesanan';

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class);
    }
}
