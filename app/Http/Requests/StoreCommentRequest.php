<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:15|max:3000',
                'user_id' => 'required',
                'post_id' => 'required',
                'tags' => 'required|min:5|max:20',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Le content est requis.',
            'content.min' => 'Le content doit faire au moins 5 caractères.',
            'content.max' => 'Le content ne doit pas dépasser 3000 caractères.',
            'tags.required' => 'Le tag est requis.',
            'tags.min' => 'Le tag ne doit pas dépasser 5 caractères.',
            'tags.max' => 'Le tag ne doit pas dépasser 20 caractères.',
            'tags.string' => 'Le tag doit être une chaîne de caractères.',
        ];  
    }
    
}
