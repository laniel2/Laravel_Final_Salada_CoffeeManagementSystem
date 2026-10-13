<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $coffee = DB::table('categories')
            ->where('name', 'Coffee')->value('id');

        $tea = DB::table('categories')
            ->where('name', 'Tea')->value('id');

        $pastries = DB::table('categories')
            ->where('name', 'Pastries')->value('id');

        DB::table('products')->upsert([
            [
                'category_id' => $coffee,
                'name' => 'Americano',
                'description' => 'Espresso with hot water',
                'price' => 90.00,
                'stock' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $coffee,
                'name' => 'Cappuccino',
                'description' => 'Espresso with steamed milk',
                'price' => 120.00,
                'stock' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $tea,
                'name' => 'Iced Tea',
                'description' => 'Refreshing cold tea',
                'price' => 60.00,
                'stock' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $pastries,
                'name' => 'Chocolate Muffin',
                'description' => 'Chocolate-flavored muffin',
                'price' => 55.00,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['name'], [
            'category_id', 'description', 'price', 'stock', 'updated_at'
        ]);
    }
}
