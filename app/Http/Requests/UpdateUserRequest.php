<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'pseudo' => 'nullable|min:2|max:20',
            'email' => 'nullable|min:5|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'pseudo.min' => 'Le content doit faire au moins 2 caractères.',
            'pseudo.max' => 'Le content ne doit pas dépasser 20 caractères.',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.unique' => 'pseudo déjà utilisé.',
            'email.min' => 'Le tag ne doit pas dépasser 5 caractères.',
            'email.max' => 'Le tag ne doit pas dépasser 20 caractères.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'email déjà utilisé.',
        ];
    }
}
