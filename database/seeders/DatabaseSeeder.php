<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        Room::firstOrCreate(
            ['name' => 'Room 1'],
            [
                'monthly_fee'     => 30.00,
                'water_rate'      => 2500,
                'electric_rate'   => 700,
                'water_mode'      => 'metered',
                'water_fixed_fee' => 0,
                'status'          => 'vacant',
            ]
        );
    }
}