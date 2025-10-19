<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Member;
use App\Models\Vehicle;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // ambil data referensi
        $member = Member::inRandomOrder()->first() ?? Member::factory()->create();
        $vehicle = $member->vehicles()->inRandomOrder()->first() ?? Vehicle::factory()->create(['member_id' => $member->id]);
        $cashier = User::whereHas('role', fn($q) => $q->where('name', 'cashier'))->inRandomOrder()->first()
                   ?? User::factory()->create(['role_id' => 2]); // asumsi role 2 = cashier
        $payment = PaymentMethod::inRandomOrder()->first() ?? PaymentMethod::factory()->create();

        // hitung nilai transaksi
        $total = fake()->randomFloat(2, 50, 500);
        $discount = $total * fake()->randomElement([0, 0.05, 0.1]);
        $tax = ($total - $discount) * 0.11;
        $grandTotal = $total - $discount + $tax;

        return [
            'member_id' => $member->id,
            'vehicle_id' => $vehicle->id,
            'cashier_id' => $cashier->id,
            'payment_method_id' => $payment->id,
            'total_amount' => $total,
            'discount' => $discount,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'status' => fake()->randomElement(['pending', 'completed']),
        ];
    }
}
