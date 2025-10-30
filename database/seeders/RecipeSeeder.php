<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 recipes using the factory
        Recipe::factory()
            ->count(20)
            ->create();

        $this->command->info('Created 20 dummy recipes successfully!');
    }
}
