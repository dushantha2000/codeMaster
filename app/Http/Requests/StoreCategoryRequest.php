<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        //currnt user check 
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')
                    ->where('user_id', auth()->id())
                    ->where('category_description', $this->description)
                    ->where('color_name', $this->color)
            ],
            'description' => 'required|string',
            'color' => 'required|string'
        ];
    }

    public function messages(): array
    {
       return [
            'name.required' => 'Please provide a name for your category.',
            'name.string'   => 'The category name must be valid text.',
            'name.max'      => 'The category name is too long (maximum 255 characters).',
            'name.unique'   => 'You have already created a category with this exact name, description, and color.',
            
            'description.required' => 'A short description is required to help identify the category.',
            'color.required'       => 'Please select a color to visually distinguish this category.',
        ];
    }
}
