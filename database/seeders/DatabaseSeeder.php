<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'name'          => 'Room 1',
            'monthly_fee'   => 30.00,
            'water_rate'    => 2500,
            'electric_rate' => 700,
            'status'        => 'vacant',
        ]);
    }
}