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
        Schema::create('detail_produk_color', function (Blueprint $table) {
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('color')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('detail_produk_ukuran', function (Blueprint $table) {
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('ukuran_id')->constrained('ukuran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_produk_color');
        Schema::dropIfExists('detail_produk_ukuran');
    }
};
