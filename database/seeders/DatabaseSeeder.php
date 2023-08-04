<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $skills_file_path = resource_path('sql/skills.sql');
        DB::unprepared(
            file_get_contents($skills_file_path)
        );

        $formations_file_path = resource_path('sql/formations.sql');
        DB::unprepared(
            file_get_contents($formations_file_path)
        );

        $links_file_path = resource_path('sql/links.sql');
        DB::unprepared(
            file_get_contents($links_file_path)
        );

        User::factory()->create([
            'name' => 'Vincent',
            'email' => 'vincent@vinvui.com',
            'password' => bcrypt('password'),
        ]);
    }
}
