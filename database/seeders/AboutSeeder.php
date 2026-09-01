<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    use ReadsSeedData;

    public function run(): void
    {
        About::query()->insert($this->seedData('about.json'));
    }
}
