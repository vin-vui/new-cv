<?php

namespace Database\Seeders;

use RuntimeException;

trait ReadsSeedData
{
    /**
     * Lit un jeu de donnees fige dans database/seeders/data.
     *
     * @return array<mixed>
     */
    protected function seedData(string $file): array
    {
        $path = database_path("seeders/data/{$file}");

        if (! is_file($path)) {
            throw new RuntimeException("Fichier de seed introuvable : {$path}");
        }

        $decoded = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        if (! is_array($decoded)) {
            throw new RuntimeException("Le fichier de seed {$file} ne contient pas un tableau JSON.");
        }

        return $decoded;
    }
}
