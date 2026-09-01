<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Le seul compte du back-office.
     *
     * Le mot de passe de production n'est pas repris ici : ce seeder installe un
     * mot de passe de developpement, a changer immediatement apres le premier
     * deploiement sur un nouveau serveur.
     */
    public function run(): void
    {
        User::query()->insert([
            'id' => 1,
            'name' => 'Vincent',
            'email' => 'vincent@vinvui.com',
            'email_verified_at' => '2024-03-13 10:23:16',
            'password' => Hash::make('password'),
            'profile_photo_path' => 'profile-photos/mUpUDHMi83jS1n4UzlU1JXIFTsf4XCUUcxCh68X7.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
