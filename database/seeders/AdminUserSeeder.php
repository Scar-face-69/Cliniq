<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cliniq.com'],
            [
                'name'     => 'admin',
                'email'    => 'admin@cliniq.com',
                'password' => Hash::make('admin@123'),
                'is_admin' => true,
            ]
        );
    }
}