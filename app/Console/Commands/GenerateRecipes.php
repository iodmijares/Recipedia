<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use Illuminate\Console\Command;

class GenerateRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recipes:generate {count=10 : Number of recipes to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dummy recipe data for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');
        
        if ($count <= 0) {
            $this->error('Count must be a positive number.');
            return 1;
        }
        
        $this->info("Generating {$count} dummy recipes...");
        
        Recipe::factory()->count($count)->create();
        
        $this->info("Successfully created {$count} recipes!");
        
        $totalRecipes = Recipe::count();
        $this->line("Total recipes in database: {$totalRecipes}");
        
        return 0;
    }
}
