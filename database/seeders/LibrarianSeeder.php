<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        // Bibliothécaire principal (compte par défaut)
        User::firstOrCreate(
            ['email' => 'biblio@iai.cm'],
            [
                'name' => 'Administrateur Libra',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Bibliothécaire secondaire (optionnel)
        User::firstOrCreate(
            ['email' => 'admin@iai.cm'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
    }
}