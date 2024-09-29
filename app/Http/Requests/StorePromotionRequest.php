<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'libelle' => 'required|string|unique:promotions,libelle',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
            'duree' => 'required|integer',
            'etat' => 'required|string',
            'photoCouverture' => 'nullable|string',
            'referentiels' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le champ libelle est requis.',
            'libelle.string' => 'Le libelle doit être une chaîne de caractères.',
            'libelle.unique' => 'Ce libelle existe déjà.',
            'dateDebut.required' => 'La date de début est requise.',
            'dateDebut.date' => 'La date de début doit être une date valide.',
            'dateFin.required' => 'La date de fin est requise.',
            'dateFin.date' => 'La date de fin doit être une date valide.',
            'duree.required' => 'La durée est requise.',
            'duree.integer' => 'La durée doit être un nombre entier.',
            'etat.required' => 'L\'état est requis.',
            'etat.string' => 'L\'état doit être une chaîne de caractères.',
            'photoCouverture.string' => 'La photo de couverture doit être une chaîne de caractères.',
            'referentiels.array' => 'Les référentiels doivent être un tableau.',
        ];
    }
}
