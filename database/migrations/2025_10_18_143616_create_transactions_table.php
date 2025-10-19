<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->foreignId('cashier_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_amount', 15, 2)->default(0); // total harga sebelum diskon dan pajak
            $table->decimal('discount', 15, 2)->default(0);     // nominal diskon
            $table->decimal('tax', 15, 2)->default(0);          // nominal pajak
            $table->decimal('grand_total', 15, 2)->default(0);  // total akhir
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
