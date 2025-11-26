<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('recipe_name');
            $table->string('submitter_name');
            $table->string('submitter_email');
            $table->string('prep_time')->nullable();
            $table->text('ingredients');
            $table->text('instructions');
            $table->string('recipe_images');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }
};
