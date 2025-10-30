<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add role column with default 'user'
            $table->enum('role', ['user', 'admin', 'moderator'])->default('user')->after('is_admin');
        });

        // Migrate existing is_admin data to role
        DB::table('users')->where('is_admin', true)->update(['role' => 'admin']);
        
        // Drop the old is_admin column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add is_admin column
            $table->boolean('is_admin')->default(false)->after('email_verified_at');
        });

        // Migrate role data back to is_admin
        DB::table('users')->where('role', 'admin')->update(['is_admin' => true]);
        
        // Drop role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
