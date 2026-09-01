<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    use ReadsSeedData;

    public function run(): void
    {
        Skill::query()->insert($this->seedData('skills.json'));
    }
}
