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
                'password' => bcrypt('admin@admin'), // Change password as needed
                'is_admin' => true, // Assuming you have this field
                'role' => 'admin'   // Assuming you have this field
            ]
        );
    }
}
