<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'order_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'status' => fake()->randomElement(['pending', 'preparing', 'completed', 'cancelled']),
            'total_amount' => 0,
        ];
    }
}
