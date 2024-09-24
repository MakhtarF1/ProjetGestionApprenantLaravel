<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReferentielRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes (ajustez selon vos besoins)
    }

    public function rules()
    {
        return [
            'libelle' => 'required|string|unique:referentiels',
            'description' => 'required|string',
            'photo_couverture' => 'required|string',
            'competences' => 'array',
        ];
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le champ libelle est requis.',
            'libelle.string' => 'Le champ libelle doit être une chaîne de caractères.',
            'libelle.unique' => 'Le libelle doit être unique.',
            'description.required' => 'Le champ description est requis.',
            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'photo_couverture.required' => 'Le champ photo couverture est requis.',
            'photo_couverture.string' => 'Le champ photo couverture doit être une chaîne de caractères.',
            'competences.array' => 'Le champ competences doit être un tableau.',
        ];
    }
}
