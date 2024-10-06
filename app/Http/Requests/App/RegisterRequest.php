<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'max:50', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:7', 'max:50', 'confirmed'],
            'agreement' => ['accepted'],
        ];
    }
}