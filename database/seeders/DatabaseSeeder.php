<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Recree l'etat de production : contenu du CV et fichiers associes.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AboutSeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
            FormationSeeder::class,
            LinkSeeder::class,
        ]);

        $this->publishStorageFiles();
    }

    /**
     * Copie les images du CV vers le disque public.
     *
     * Les enregistrements referencent des chemins /storage/image/..., qui ne
     * resolvent que si ces fichiers sont presents et que storage:link a ete
     * execute.
     */
    protected function publishStorageFiles(): void
    {
        $source = database_path('seeders/storage');

        if (! File::isDirectory($source)) {
            $this->command?->warn("Aucun fichier a publier : {$source} est absent.");

            return;
        }

        File::copyDirectory($source, Storage::disk('public')->path(''));

        $count = count(File::allFiles($source));
        $this->command?->info("{$count} fichiers publies sur le disque public.");
    }
}
