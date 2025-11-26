<?php

namespace Tests\Unit;

use App\Models\Recipe;
use PHPUnit\Framework\TestCase;

class RecipeModelTest extends TestCase
{
    /** @test */
    public function it_casts_recipe_images_to_array()
    {
        $recipe = new Recipe([
            'recipe_images' => json_encode(['img1.jpg', 'img2.jpg'])
        ]);
        $this->assertIsArray($recipe->recipe_images);
        $this->assertEquals(['img1.jpg', 'img2.jpg'], $recipe->recipe_images);
    }

    /** @test */
    public function it_defaults_is_approved_to_false()
    {
        $recipe = new Recipe();
        $this->assertFalse($recipe->is_approved);
    }
}
