<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'no_rekening',
    ];

    protected $table = 'bank';

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}
