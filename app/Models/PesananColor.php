<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'color_id',
        'qty',
    ];

    protected $table = 'detail_pesanan_color';

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
