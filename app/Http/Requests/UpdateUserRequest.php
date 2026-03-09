<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'conseiller']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name' => 'nullable|string|max:100',
            'email' => ['nullable', 'email', Rule::unique('users','email')->ignore($userId)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => ['nullable', Rule::in(['client', 'conseiller', 'admin'])],
            'statut' => ['nullable', Rule::in(['actif','suspendu','supprime'])],
        ];
    }
}
