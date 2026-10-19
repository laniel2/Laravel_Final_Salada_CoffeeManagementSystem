<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);

        // Add a small factory-generated sample set with valid relationships.
        $category = Category::factory()->create();
        $products = Product::factory()->count(2)->for($category)->create();
        $customers = Customer::factory()->count(2)->create();

        foreach ($customers as $customer) {
            $order = $customer->orders()->create([
                'order_date' => now()->subDays(fake()->numberBetween(0, 14)),
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            $product = $products->random();
            $quantity = fake()->numberBetween(1, 3);
            OrderItem::factory()->for($order)->for($product)->create([
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $quantity,
            ]);
            $order->update(['total_amount' => $order->items()->sum('subtotal')]);
        }
    }
}
