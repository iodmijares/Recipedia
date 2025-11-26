<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'recipe_name' => 'required|string|max:255',
            'submitter_name' => 'required|string|max:255',
            'submitter_email' => 'required|email',
            'prep_time' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'recipe_images' => 'required',
            'recipe_images.*' => 'image|max:2048',
        ];
    }
}
