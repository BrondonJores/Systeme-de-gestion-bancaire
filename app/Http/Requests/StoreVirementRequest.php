<?php

namespace App\Http\Requests;

use App\Models\CompteBancaire;
use Illuminate\Foundation\Http\FormRequest;

class StoreVirementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['client', 'conseiller', 'admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_compte_emetteur' => 'required|integer|exists:compte_bancaires,id',
            'id_compte_destinataire' => 'required|integer|exists:compte_bancaires,id',
            'montant' => 'required|numeric|min:1',
            'type' => 'required|in:courant,epargne,frais,interet',
            'description' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:50',
        ];
    }
}
