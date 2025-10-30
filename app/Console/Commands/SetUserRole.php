<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-role {email : The email of the user} {role=admin : The role to assign (user, admin, moderator)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a user role by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');
        
        // Validate role
        $allowedRoles = ['user', 'admin', 'moderator'];
        if (!in_array($role, $allowedRoles)) {
            $this->error("Invalid role '{$role}'. Allowed roles: " . implode(', ', $allowedRoles));
            return 1;
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->role === $role) {
            $this->info("User '{$email}' already has the role '{$role}'.");
            return 0;
        }
        
        $oldRole = $user->role;
        $user->update(['role' => $role]);
        
        $this->info("User '{$email}' role changed from '{$oldRole}' to '{$role}' successfully!");
        
        return 0;
    }
}
