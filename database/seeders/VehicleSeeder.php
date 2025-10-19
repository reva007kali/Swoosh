<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::all()->each(function ($member) {
            Vehicle::factory(rand(1, 3))->create([
                'member_id' => $member->id,
            ]);
        });
    }
}
