<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Toyota', 'Honda', 'Yamaha', 'Suzuki', 'Daihatsu', 'Mitsubishi'];
        $types = ['car', 'motorcycle'];
        $colors = ['black', 'white', 'red', 'blue', 'silver', 'gray'];

        return [
            'member_id' => Member::inRandomOrder()->first()?->id ?? Member::factory(),
            'plate_number' => strtoupper($this->faker->bothify('B #### ??')),
            'brand' => $this->faker->randomElement($brands),
            'model' => ucfirst($this->faker->word()),
            'color' => $this->faker->randomElement($colors),
            'type' => $this->faker->randomElement($types),
            'year' => $this->faker->year(),
        ];
    }
}
