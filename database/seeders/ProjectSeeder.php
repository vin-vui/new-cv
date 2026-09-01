<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    use ReadsSeedData;

    public function run(): void
    {
        $rows = $this->seedData('projects.json');

        $relations = [];
        $projects = [];

        foreach ($rows as $row) {
            $relations[$row['id']] = Arr::pull($row, 'skill_ids', []);
            $projects[] = $row;
        }

        Project::query()->insert($projects);

        foreach ($relations as $projectId => $skillIds) {
            Project::findOrFail($projectId)->skills()->attach($skillIds);
        }
    }
}
