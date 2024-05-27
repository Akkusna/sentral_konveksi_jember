<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('qty');
            $table->integer("grand_total")->nullable();
            $table->string("bukti")->nullable();
            $table->string("bukti_pelunasan")->nullable();
            $table->string("detail_alamat")->nullable();
            $table->string("detail_pesanan")->nullable();
            $table->string("nota")->nullable();
            $table->string("qr_code")->nullable();
            $table->enum("status", ['menunggu konfirmasi', 'proses', 'selesai']);
            $table->enum("pengiriman", ['pengiriman', 'ambil sendiri']);
            $table->enum("status_pembayaran", ['belum_bayar', 'lunas', 'dp']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
