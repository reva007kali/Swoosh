<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $members = User::whereHas('role', fn($q) => $q->where('name', 'member'))->get();

        foreach ($members as $user) {
            Member::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'balance' => rand(0, 500000), // contoh: saldo acak
                    'member_point' => rand(0, 1000),
                ]
            );
        }
    }
}
