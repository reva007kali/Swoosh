<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique(); // untuk public identifier
            $table->string('qr_code')->unique()->nullable(); // kode unik QR
            // relasi ke user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // data dasar disinkron dari user (redundan tapi mempercepat query dashboard)
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();

            // saldo dan poin
            $table->decimal('balance', 15, 2)->default(0); // bisa top up & transaksi
            $table->integer('member_point')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
