<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            'juan@example.com',
            'maria@example.com',
            'pedro@example.com',
        ];

        foreach ($customers as $email) {
            $customerId = DB::table('customers')
                ->where('email', $email)
                ->value('id');

            if (!$customerId) {
                continue;
            }

            $orderDate = '2026-10-01 10:00:00';

            $exists = DB::table('orders')
                ->where('customer_id', $customerId)
                ->where('order_date', $orderDate)
                ->exists();

            if (!$exists) {
                DB::table('orders')->insert([
                    'customer_id' => $customerId,
                    'order_date' => $orderDate,
                    'status' => 'completed',
                    'total_amount' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
