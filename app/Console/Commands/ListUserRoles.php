<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list-roles {--role= : Filter by specific role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users and their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleFilter = $this->option('role');
        
        $query = User::select(['id', 'name', 'email', 'role', 'email_verified_at']);
        
        if ($roleFilter) {
            $allowedRoles = ['user', 'admin', 'moderator'];
            if (!in_array($roleFilter, $allowedRoles)) {
                $this->error("Invalid role '{$roleFilter}'. Allowed roles: " . implode(', ', $allowedRoles));
                return 1;
            }
            $query->where('role', $roleFilter);
        }
        
        $users = $query->orderBy('role')->orderBy('name')->get();
        
        if ($users->isEmpty()) {
            $this->info('No users found.');
            return 0;
        }
        
        $headers = ['ID', 'Name', 'Email', 'Role', 'Verified'];
        $rows = [];
        
        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                ucfirst($user->role),
                $user->email_verified_at ? 'Yes' : 'No'
            ];
        }
        
        $this->table($headers, $rows);
        
        return 0;
    }
}
