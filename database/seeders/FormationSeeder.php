<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    use ReadsSeedData;

    public function run(): void
    {
        Formation::query()->insert($this->seedData('formations.json'));
    }
}
