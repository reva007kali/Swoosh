<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $categories = ['car', 'motorcycle'];
        $durations = ['15 menit', '30 menit', '45 menit', '1 jam'];

        return [
            'name' => ucfirst($this->faker->word()) . ' Wash',
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(20000, 100000),
            'duration' => $this->faker->randomElement($durations),
            'category' => $this->faker->randomElement($categories),
            'is_active' => true,
        ];
    }
}
