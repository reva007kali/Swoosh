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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('image_url')->nullable(); // URL gambar layanan
            $table->string('name');                   // nama layanan, misal "Cuci Mobil", "Waxing", "Interior Cleaning"
            $table->text('description')->nullable();  // deskripsi opsional
            $table->decimal('price', 15, 2); // harga layanan
            $table->string('duration')->nullable();   // misal "30 menit", "1 jam"
            $table->string('category')->nullable();   // bisa digunakan untuk grouping (misal: car, motorcycle)
            $table->boolean('is_active')->default(true); // apakah layanan aktif di daftar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
