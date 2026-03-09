<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompteBancaireRequest extends FormRequest
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
        return [
            'solde' => 'nullable|numeric|min:0',
            'has_fees' => 'boolean',
            'frais' => 'nullable|numeric|min:0',
            'has_interest' => 'boolean',
            'taux_interet' => 'nullable|numeric|min:0',
            'plafond' => 'nullable|numeric|min:0',
            'statut' => 'nullable|in:actif,ferme,suspendu',
        ];
    }
}
