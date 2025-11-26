<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $recipes = Recipe::all();
        foreach ($recipes as $recipe) {
            // Each recipe gets 3 ratings from random users
            $raters = $users->random(min(3, $users->count()));
            foreach ($raters as $user) {
                Rating::create([
                    'recipe_id' => $recipe->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5),
                    'comment' => fake()->sentence(),
                ]);
            }
        }
    }
}
