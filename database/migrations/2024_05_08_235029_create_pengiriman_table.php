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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['proses', 'dalam perjalanan', 'sampai'])->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat_tujuan')->nullable();
            $table->date('tanggal_pengiriman')->nullable();
            $table->string('estimasi', 25)->nullable();
            $table->string("jasa_ekspedisi")->nullable();
            $table->integer("harga_ongkir")->nullable();
            $table->date('tanggal_tiba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
