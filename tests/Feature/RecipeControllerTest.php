<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_approved_recipes_on_index()
    {
        Recipe::factory()->count(3)->create(['is_approved' => true]);
        Recipe::factory()->count(2)->create(['is_approved' => false]);

        $response = $this->get(route('recipes.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Community Recipe Book');
        $response->assertDontSeeText('Pending');
    }

    /** @test */
    public function it_does_not_show_unapproved_recipe_on_show()
    {
        $recipe = Recipe::factory()->create(['is_approved' => false]);
        $response = $this->get(route('recipes.show', $recipe));
        $response->assertStatus(404);
    }

    /** @test */
    public function it_shows_approved_recipe_on_show()
    {
        $recipe = Recipe::factory()->create(['is_approved' => true]);
        $response = $this->get(route('recipes.show', $recipe));
        $response->assertStatus(200);
        $response->assertSeeText($recipe->recipe_name);
    }
}
