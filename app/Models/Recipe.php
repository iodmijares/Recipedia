<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'recipe_name',
        'submitter_name',
        'submitter_email',
        'prep_time',
        'ingredients',
        'instructions',
        'recipe_images',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'recipe_images' => 'array',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Relationship to the user who uploaded the recipe
    public function user()
    {
        return $this->belongsTo(User::class, 'submitter_email', 'email');
    }
}
