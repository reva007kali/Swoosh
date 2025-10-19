<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $services = [
            [
                'name' => 'Cuci Mobil Reguler',
                'description' => 'Pencucian standar untuk mobil ukuran kecil hingga sedang.',
                'price' => 35000,
                'duration' => '30 menit',
                'category' => 'car',
            ],
            [
                'name' => 'Cuci Motor Cepat',
                'description' => 'Pencucian cepat untuk sepeda motor.',
                'price' => 15000,
                'duration' => '15 menit',
                'category' => 'motorcycle',
            ],
            [
                'name' => 'Wax & Polish',
                'description' => 'Perawatan eksterior dengan waxing dan pemolesan.',
                'price' => 80000,
                'duration' => '1 jam',
                'category' => 'car',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
