<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $route = User::create([
            'email' => 'admin@gmail.com',
            'name' => 'adminadmin',
            'email_verified_at' => now(),
            'password' => Hash::make('rahasia123'),
            'is_admin' => 1,
        ]);

        $route = User::create([
            'email' => 'user@gmail.com',
            'name' => 'useruser',
            'email_verified_at' => now(),
            'password' => Hash::make('rahasia123'),
            'is_admin' => 0,
        ]);
    }
}
