<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // buat 30 transaksi
        Transaction::factory(30)
            ->create()
            ->each(function ($transaction) {
                // buat 1–3 item per transaksi
                $items = TransactionItem::factory(rand(1, 3))
                    ->make(['transaction_id' => $transaction->id]);

                // simpan items
                $transaction->items()->saveMany($items);

                // update total dari items
                $total = $items->sum('subtotal');
                $discount = $transaction->discount;
                $tax = ($total - $discount) * 0.11;
                $grandTotal = $total - $discount + $tax;

                $transaction->update([
                    'total_amount' => $total,
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                ]);
            });
    }
}
