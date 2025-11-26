<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recipes = [
            [
                'name' => 'Classic Beef Stew',
                'ingredients' => "2 lbs beef chuck, cubed\n1 large onion, diced\n3 carrots, sliced\n3 potatoes, cubed\n2 cups beef broth\n2 tbsp tomato paste\n1 tsp thyme\nSalt and pepper to taste",
                'instructions' => "1. Heat oil in a large pot over medium-high heat.\n2. Brown the beef cubes on all sides.\n3. Add onions and cook until softened.\n4. Add tomato paste and cook for 1 minute.\n5. Add broth, carrots, potatoes, and seasonings.\n6. Bring to a boil, then reduce heat and simmer for 1.5 hours.\n7. Serve hot with crusty bread.",
                'prep_time' => '2 hours'
            ],
            [
                'name' => 'Chicken Adobo',
                'ingredients' => "2 lbs chicken pieces\n1/2 cup soy sauce\n1/4 cup white vinegar\n6 cloves garlic, minced\n2 bay leaves\n1 tsp black peppercorns\n1 tbsp brown sugar\n1 onion, sliced",
                'instructions' => "1. Combine soy sauce, vinegar, garlic, bay leaves, and peppercorns in a bowl.\n2. Marinate chicken in mixture for 30 minutes.\n3. Heat oil in a pan and brown chicken pieces.\n4. Add marinade and bring to a boil.\n5. Add onions and brown sugar.\n6. Simmer for 30-40 minutes until chicken is tender.\n7. Serve with steamed rice.",
                'prep_time' => '1 hour 30 minutes'
            ],
            [
                'name' => 'Pasta Carbonara',
                'ingredients' => "400g spaghetti\n200g pancetta or bacon, diced\n4 large eggs\n1 cup grated Parmesan cheese\n2 cloves garlic, minced\nBlack pepper\nSalt",
                'instructions' => "1. Cook spaghetti according to package directions.\n2. Fry pancetta until crispy.\n3. Beat eggs with Parmesan and black pepper.\n4. Drain pasta, reserving 1 cup pasta water.\n5. Add hot pasta to pancetta.\n6. Remove from heat and quickly stir in egg mixture.\n7. Add pasta water if needed for creaminess.\n8. Serve immediately.",
                'prep_time' => '30 minutes'
            ],
            [
                'name' => 'Vegetable Fried Rice',
                'ingredients' => "3 cups cooked rice, cooled\n2 eggs, beaten\n1 cup mixed vegetables (peas, carrots, corn)\n3 green onions, chopped\n2 cloves garlic, minced\n2 tbsp soy sauce\n1 tbsp sesame oil\nSalt to taste",
                'instructions' => "1. Heat oil in a large wok or skillet.\n2. Scramble eggs and remove from pan.\n3. Add garlic and vegetables, stir-fry for 2 minutes.\n4. Add rice and break up clumps.\n5. Add soy sauce and sesame oil.\n6. Return eggs to pan and mix well.\n7. Garnish with green onions.\n8. Serve hot.",
                'prep_time' => '20 minutes'
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'ingredients' => "2 1/4 cups all-purpose flour\n1 tsp baking soda\n1 tsp salt\n1 cup butter, softened\n3/4 cup granulated sugar\n3/4 cup brown sugar\n2 eggs\n2 tsp vanilla extract\n2 cups chocolate chips",
                'instructions' => "1. Preheat oven to 375°F.\n2. Mix flour, baking soda, and salt in a bowl.\n3. Cream butter and sugars until fluffy.\n4. Beat in eggs and vanilla.\n5. Gradually add flour mixture.\n6. Stir in chocolate chips.\n7. Drop spoonfuls on baking sheet.\n8. Bake 9-11 minutes until golden brown.",
                'prep_time' => '45 minutes'
            ],
            [
                'name' => 'Grilled Salmon',
                'ingredients' => "4 salmon fillets\n2 tbsp olive oil\n1 lemon, sliced\n2 cloves garlic, minced\n1 tsp dried dill\nSalt and pepper\n1 tbsp honey\n1 tbsp soy sauce",
                'instructions' => "1. Preheat grill to medium-high heat.\n2. Mix olive oil, garlic, dill, honey, and soy sauce.\n3. Season salmon with salt and pepper.\n4. Brush salmon with oil mixture.\n5. Grill for 4-5 minutes per side.\n6. Top with lemon slices during cooking.\n7. Cook until fish flakes easily.\n8. Serve with vegetables.",
                'prep_time' => '25 minutes'
            ],
            [
                'name' => 'Thai Green Curry',
                'ingredients' => "2 tbsp green curry paste\n1 can coconut milk\n1 lb chicken, sliced\n1 eggplant, cubed\n1 bell pepper, sliced\n2 tbsp fish sauce\n1 tbsp brown sugar\nFresh basil leaves\nJasmine rice",
                'instructions' => "1. Heat 1/4 cup coconut milk in a pan.\n2. Add curry paste and fry for 1 minute.\n3. Add chicken and cook until white.\n4. Add remaining coconut milk.\n5. Add vegetables, fish sauce, and sugar.\n6. Simmer for 15 minutes.\n7. Stir in basil leaves.\n8. Serve over jasmine rice.",
                'prep_time' => '35 minutes'
            ],
            [
                'name' => 'Homemade Pizza',
                'ingredients' => "1 pizza dough\n1/2 cup pizza sauce\n2 cups mozzarella cheese\n1/4 cup pepperoni\n1/4 cup mushrooms, sliced\n1/4 cup bell peppers\n2 tbsp olive oil\nOregano and basil",
                'instructions' => "1. Preheat oven to 475°F.\n2. Roll out pizza dough on floured surface.\n3. Transfer to pizza stone or baking sheet.\n4. Brush with olive oil.\n5. Spread sauce evenly.\n6. Add cheese and toppings.\n7. Sprinkle with herbs.\n8. Bake for 12-15 minutes until golden.",
                'prep_time' => '40 minutes'
            ],
            [
                'name' => 'Beef Burger',
                'ingredients' => "1 lb ground beef\n4 burger buns\n4 cheese slices\n1 tomato, sliced\n1 onion, sliced\nLettuce leaves\nPickles\nKetchup and mustard\nSalt and pepper",
                'instructions' => "1. Season ground beef with salt and pepper.\n2. Form into 4 patties.\n3. Heat grill or skillet over medium-high heat.\n4. Cook patties for 4-5 minutes per side.\n5. Add cheese in last minute of cooking.\n6. Toast buns lightly.\n7. Assemble with toppings.\n8. Serve with fries.",
                'prep_time' => '25 minutes'
            ],
            [
                'name' => 'Chicken Noodle Soup',
                'ingredients' => "1 whole chicken\n8 cups water\n2 carrots, sliced\n2 celery stalks, chopped\n1 onion, diced\n2 cups egg noodles\n2 bay leaves\nFresh parsley\nSalt and pepper",
                'instructions' => "1. Boil chicken in water with bay leaves for 1 hour.\n2. Remove chicken and shred meat.\n3. Strain broth and return to pot.\n4. Add vegetables and simmer for 15 minutes.\n5. Add noodles and cook for 8 minutes.\n6. Return shredded chicken to pot.\n7. Season with salt and pepper.\n8. Garnish with parsley.",
                'prep_time' => '2 hours'
            ],
            [
                'name' => 'Greek Salad',
                'ingredients' => "2 cucumbers, chopped\n4 tomatoes, wedged\n1 red onion, sliced\n1/2 cup Kalamata olives\n200g feta cheese, cubed\n1/4 cup olive oil\n2 tbsp red wine vinegar\n1 tsp oregano\nSalt and pepper",
                'instructions' => "1. Combine cucumbers, tomatoes, and onion in a bowl.\n2. Add olives and feta cheese.\n3. Whisk olive oil, vinegar, and oregano.\n4. Pour dressing over salad.\n5. Season with salt and pepper.\n6. Toss gently to combine.\n7. Let marinate for 15 minutes.\n8. Serve chilled.",
                'prep_time' => '20 minutes'
            ],
            [
                'name' => 'Beef Stir Fry',
                'ingredients' => "1 lb beef sirloin, sliced thin\n2 tbsp soy sauce\n1 tbsp cornstarch\n2 bell peppers, sliced\n1 broccoli head, florets\n2 tbsp vegetable oil\n2 cloves garlic, minced\n1 tbsp ginger, grated\nGreen onions",
                'instructions' => "1. Marinate beef in soy sauce and cornstarch.\n2. Heat oil in wok over high heat.\n3. Stir-fry beef for 2-3 minutes until browned.\n4. Remove beef and set aside.\n5. Stir-fry vegetables for 3-4 minutes.\n6. Add garlic and ginger, cook 30 seconds.\n7. Return beef to wok and toss.\n8. Garnish with green onions.",
                'prep_time' => '25 minutes'
            ]
        ];

        $recipe = $this->faker->randomElement($recipes);
        
        $images = [
            'beef-stew.jpg',
            'chicken-adobo.jpg',
            'pasta-carbonara.jpg',
            'fried-rice.jpg',
            'cookies.jpg',
            'caesar-salad.jpg',
            'beef-tacos.jpg',
            'risotto.jpg',
            'chicken-curry.jpg',
            'pizza.jpg',
            'burger.jpg',
            'soup.jpg'
        ];

        return [
            'recipe_name' => $recipe['name'],
            'submitter_name' => $this->faker->name(),
            'submitter_email' => $this->faker->unique()->safeEmail(),
            'prep_time' => $recipe['prep_time'],
            'ingredients' => $recipe['ingredients'],
            'instructions' => $recipe['instructions'],
            'recipe_images' => $this->faker->randomElement($images),
            'is_approved' => $this->faker->boolean(80), // 80% chance of being approved
        ];
    }
}
