<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'adresse' => 'sometimes|required|string|max:255',
            'telephone' => 'sometimes|required|string|max:20|unique:users,telephone',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'fonction' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'statut' => 'nullable|string|max:50',
            'password' => 'sometimes|required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'adresse.required' => 'L\'adresse est requise.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être un format valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.unique' => 'Cet telephone est déjà utilisé.',
            'photo.image' => 'La photo doit être une image valide.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'password.required' => 'Le mot de passe est requis lors de la mise à jour.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ];
    }
}
