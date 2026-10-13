<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->upsert([
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan@example.com',
                'phone' => '09171234567',
                'address' => 'Tagbilaran City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@example.com',
                'phone' => '09181234567',
                'address' => 'Panglao, Bohol',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pedro Reyes',
                'email' => 'pedro@example.com',
                'phone' => '09191234567',
                'address' => 'Dauis, Bohol',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['email'], ['name', 'phone', 'address', 'updated_at']);
    }
}
