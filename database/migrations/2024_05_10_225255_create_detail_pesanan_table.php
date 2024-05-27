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
        Schema::create('detail_pesanan_bahan_baku', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('bahan_baku_id')->constrained('bahan_baku')->onDelete('cascade')->nullable();
            $table->string('qty')->nullable();
            $table->timestamps();

            $table->primary(['pesanan_id', 'bahan_baku_id']);
        });

        Schema::create('detail_pesanan_color', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('color')->onDelete('cascade')->nullable();
            $table->string('qty')->nullable();
            $table->timestamps();
        });
        Schema::create('detail_pesanan_ukuran', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('ukuran_id')->constrained('ukuran')->onDelete('cascade')->nullable();
            $table->string('qty')->nullable();
            $table->timestamps();
        });
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade')->nullable();
            $table->foreignId('color_id')->constrained('color')->onDelete('cascade')->nullable();
            $table->foreignId('ukuran_id')->constrained('ukuran')->onDelete('cascade')->nullable();
            $table->string('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan_bahan_baku');
        Schema::dropIfExists('detail_pesanan_ukuran');
        Schema::dropIfExists('detail_pesanan_color');
        Schema::dropIfExists('detail_pesanan');
    }
};
