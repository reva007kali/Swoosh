<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $cashierRole = Role::where('name', 'cashier')->first();
        $memberRole = Role::where('name', 'member')->first();

        // Pastikan role sudah ada
        if (!$adminRole || !$cashierRole || !$memberRole) {
            $this->command->warn('⚠️ Roles belum tersedia. Jalankan RoleSeeder dulu.');
            return;
        }

        // 1 admin
        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@swooshcarwash.com',
            'phone' => '081111111111',
            'role_id' => $adminRole->id,
        ]);
        $cashiers = [
            [
                'name' => 'Vinka',
                'email' => 'vinka@swooshcarwash.com',
                'phone' => '08123456789',
            ],
            [
                'name' => 'Vara',
                'email' => 'vara@swooshcarwash.com',
                'phone' => '08123456788',
            ],
        ];

        foreach ($cashiers as $cashier) {
            User::factory()->create(array_merge($cashier, [
                'role_id' => $cashierRole->id,
            ]));
        }

        // sisa 17 member
        // User::factory(17)->create([
        //     'role_id' => $memberRole->id,
        // ]);
    }
}
