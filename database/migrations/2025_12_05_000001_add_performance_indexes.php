<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds performance indexes for frequently queried columns.
     */
    public function up(): void
    {
        // Add index on recipes.is_approved for filtering approved/pending recipes
        Schema::table('recipes', function (Blueprint $table) {
            $table->index('is_approved');
        });

        // Add index on users.role for admin/role-based queries
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        // Before adding unique constraint, remove any duplicate ratings
        // Keep only the most recent rating per user/recipe combination
        DB::statement("
            DELETE r1 FROM ratings r1
            INNER JOIN ratings r2
            WHERE r1.user_id = r2.user_id
              AND r1.recipe_id = r2.recipe_id
              AND r1.id < r2.id
        ");

        // Add composite unique index for ratings (user_id + recipe_id)
        // This prevents duplicate ratings and improves lookup performance
        Schema::table('ratings', function (Blueprint $table) {
            $table->unique(['user_id', 'recipe_id'], 'ratings_user_recipe_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex(['is_approved']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropUnique('ratings_user_recipe_unique');
        });
    }
};
