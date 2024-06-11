<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Color;
use App\Models\Kategori;
use App\Models\Ukuran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ukuran = Ukuran::create([
            'ukuran' => 'L'
        ]);
        $ukuran = Ukuran::create([
            'ukuran' => 'S'
        ]);
        $ukuran = Ukuran::create([
            'ukuran' => 'M'
        ]);
        $ukuran = Ukuran::create([
            'ukuran' => 'XL'
        ]);
        $ukuran = Ukuran::create([
            'ukuran' => 'XXL'
        ]);

        $warna = Color::create([
            'name_color' => 'Blue',
            'code_color' => '#0015FF'
        ]);

        $warna = Color::create([
            'name_color' => 'Green',
            'code_color' => '#00F75B'
        ]);

        $kategori = Kategori::create([
            'nama' => 'Jacket',
        ]);
        $bank = Bank::create([
            'nama' => 'BRI',
            'no_rekening' => '2012277221',
        ]);
    }
}
