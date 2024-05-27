<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'bahan_baku_id',
        'qty',
    ];

    protected $table = 'detail_pesanan_bahan_baku';
    public $incrementing = false;
    protected $primaryKey = ['pesanan_id', 'bahan_baku_id'];
    public $timestamps = true;

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($pesananBahanBaku) {
            $transaksiKeluar = TransaksiKeluar::updateOrCreate(
                [
                    'bahan_baku_id' => $pesananBahanBaku->bahan_baku_id,
                    'pesanan_id' => $pesananBahanBaku->pesanan_id,
                ],
                [
                    'qty' => $pesananBahanBaku->qty,
                ]
            );

            $bahanBaku = BahanBaku::find($pesananBahanBaku->bahan_baku_id);
            $totalQtyKeluar = TransaksiKeluar::where('bahan_baku_id', $bahanBaku->id)->sum('qty');
            $totalQtyMasuk = TransaksiMasuk::where('bahan_baku_id', $bahanBaku->id)->sum('qty');
            $bahanBaku->qty = $totalQtyMasuk - $totalQtyKeluar;
            $bahanBaku->save();
        });
    }
}
