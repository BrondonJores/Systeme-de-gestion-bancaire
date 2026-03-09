<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompteBancaireRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:courant,epargne',
            'solde' => 'required|numeric|min:0',
            'has_fees' => 'boolean',
            'frais' => 'nullable|numeric|min:0',
            'has_interest' => 'boolean',
            'taux_interet' => 'nullable|numeric|min:0',
            'plafond' => 'required|numeric|min:0',
            'statut' => 'required|in:actif,ferme,suspendu',
            'rib' => 'required|string|unique:compte_bancaires,rib',
        ];
    }
}
