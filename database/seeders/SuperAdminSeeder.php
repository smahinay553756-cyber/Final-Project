<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('role', 'superadmin')->exists()) {
            User::create([
                'name'     => 'Super Admin',
                'username' => 'superadmin',
                'email'    => 'superadmin@gmail.com',
                'password' => Hash::make('123456'),
                'role'     => 'superadmin',
                'approved' => true,
            ]);
        }
    }
}
