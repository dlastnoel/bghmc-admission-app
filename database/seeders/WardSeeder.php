<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wards = [
            'General Ward',
            'Public Ward',
            'Private Ward'
        ];

        foreach ($wards as $ward) {

            for ($i = 1; $i <= 3; $i++) {
                Ward::factory()->create([
                    'name' => $ward . ' ' . $i,
                    'capacity' => rand(1, 10)
                ]);
            }
        }

        Ward::factory()->create([
            'name' => 'ICU',
            'description' => 'Intensive Care Unit',
            'capacity' => 2,
        ]);
    }
}
