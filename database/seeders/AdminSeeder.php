<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [ 'email' => 'admin@recipedia.com' ],
            [
                'name' => 'Admin',
                'email' => 'admin@recipedia.com',
                'password' => 'admin@admin', // Password will be hashed by the model cast
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
