<?php

namespace Database\Seeders;

use App\Models\Launche;
use Illuminate\Database\Seeder;

class LauncheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Launche::create(['provider' => 'Cultura']);
    }
}
