<?php

namespace Database\Seeders;

use App\Models\settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (settings::count() == 0) {
            settings::create([
                'return_days' => 20,
                'fine' => 5
            ]);
        }
    }
}
