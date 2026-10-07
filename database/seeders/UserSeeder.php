<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@sehatin.id'],
            [
                'name'     => 'Admin SEHATIN',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // Sample user
        User::firstOrCreate(
            ['email' => 'user@sehatin.id'],
            [
                'name'     => 'Pengguna SEHATIN',
                'password' => Hash::make('user123'),
                'role'     => 'user',
            ]
        );
    }
}
