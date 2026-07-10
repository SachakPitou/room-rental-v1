<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@roomrental.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@roomrental.com',
                'password' => Hash::make('admin1234'),
            ]
        );
    }
}