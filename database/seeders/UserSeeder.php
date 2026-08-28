<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Admin Account
        User::updateOrCreate(
            ['email' => 'admin@asetra.com'],
            [
                'name' => 'Admin Asetra',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed Operator Account
        User::updateOrCreate(
            ['email' => 'operator@asetra.com'],
            [
                'name' => 'Operator Asetra',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ]
        );
    }
}
