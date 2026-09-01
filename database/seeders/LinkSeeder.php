<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    use ReadsSeedData;

    public function run(): void
    {
        Link::query()->insert($this->seedData('links.json'));
    }
}
