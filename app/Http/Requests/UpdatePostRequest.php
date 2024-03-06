<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'content' => 'required|min:5|max:3000',
            'tags' => 'required|min:5|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Le contenu est requis.',
            'content.min' => 'Le contenu doit faire au moins 5 caractères.',
            'content.max' => 'Le contenu ne doit pas dépasser 3000 caractères.',
            'tags.required' => 'Le tags est requis.',
            'tags.min' => 'Le tags doit faire plus de 5 caractères.',
            'tags.max' => 'Le tags ne doit pas dépasser 50 caractères.',
            'tags.string' => 'Le tags doit être une chaîne de caractères.',
        ];
    }
}
