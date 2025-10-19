<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['name' => 'Cash', 'code' => 'CASH', 'description' => 'Pembayaran tunai di tempat'],
            ['name' => 'Balance', 'code' => 'BAL', 'description' => 'Pembayaran menggunakan saldo member'],
            ['name' => 'Card', 'code' => 'CARD', 'description' => 'Pembayaran via kartu debit/kredit'],
            ['name' => 'QRIS', 'code' => 'QRIS', 'description' => 'Pembayaran via QRIS'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
