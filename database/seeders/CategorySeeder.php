<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->upsert([
            [
                'name' => 'Coffee',
                'description' => 'Espresso and brewed coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tea',
                'description' => 'Hot and iced tea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pastries',
                'description' => 'Fresh bakery products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name'], ['description', 'updated_at']);
    }
}
