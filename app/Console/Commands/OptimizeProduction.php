<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all caches and re-cache configuration, routes, and views for production.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing all caches...');
        
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');

        $this->info('Caching for production...');

        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache'); // Only cache views if you are sure they are static

        $this->info('Production optimization complete!');
    }
}
