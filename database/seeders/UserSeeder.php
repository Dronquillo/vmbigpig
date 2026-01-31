<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // 🔒 nunca guardes plano
                'admin' => true,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Visitante',
                'email' => 'visitante@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('visitante123'),
                'admin' => false,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
