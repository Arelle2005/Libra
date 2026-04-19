<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrower;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Utiliser firstOrCreate pour éviter les doublons
        Borrower::firstOrCreate(
            ['matricule' => 'IAI2023GL003'],
            [
                'name' => 'Paul Nkomo',
                'email' => 'paul@iai.cm',
                'password' => Hash::make('password123'),
                'phone' => '670000003',
                'type' => 'student',
            ]
        );
    }
}