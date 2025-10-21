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
            // Mobil
            [
                'category' => 'Mobil',
                'name' => 'Express Robotic',
                'price' => 65000,
                'description' => 'Exterior + Semir Ban',
            ],
            [
                'category' => 'Mobil',
                'name' => 'Reguler Robotic',
                'price' => 70000,
                'description' => 'Express Robotic + Vacuum + Semir Ban',
            ],
            [
                'category' => 'Mobil',
                'name' => 'Reguler Hydraulic',
                'price' => 80000,
                'description' => 'Exterior + Vacuum + Semir Ban',
            ],
            [
                'category' => 'Mobil',
                'name' => 'Premium Hydraulic',
                'price' => 115000,
                'description' => 'Exterior + Vacuum + Wax + Semir Ban',
            ],

            // Motor
            [
                'category' => 'Motor',
                'name' => 'Reguler Wash',
                'price' => 35000,
                'description' => 'Shampo + Semir Ban',
            ],
            [
                'category' => 'Motor',
                'name' => 'Premium Wash',
                'price' => 45000,
                'description' => 'Shampo + Semir Ban + Wax',
            ],
            [
                'category' => 'Motor',
                'name' => 'Luxury Motor',
                'price' => 100000,
                'description' => 'Shampo + Semir Ban + Wax',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
