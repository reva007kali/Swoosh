<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionItem>
 */
class TransactionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();
        $quantity = fake()->numberBetween(1, 3);
        $price = $service->price ?? fake()->randomFloat(2, 10, 100);

        return [
            'service_id' => $service->id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $price * $quantity,
        ];
    }
}
