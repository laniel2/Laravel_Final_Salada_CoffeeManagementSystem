<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = DB::table('orders')->get();

        foreach ($orders as $order) {
            $product = DB::table('products')
                ->where('name', 'Americano')
                ->first();

            if (!$product) {
                continue;
            }

            $exists = DB::table('order_items')
                ->where('order_id', $order->id)
                ->where('product_id', $product->id)
                ->exists();

            if (!$exists) {
                $quantity = 2;
                $subtotal = $product->price * $quantity;

                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('orders')
                    ->where('id', $order->id)
                    ->update([
                        'total_amount' => DB::table('order_items')
                            ->where('order_id', $order->id)
                            ->sum('subtotal'),
                        'updated_at' => now(),
                    ]);
            }
        }
    }
}
