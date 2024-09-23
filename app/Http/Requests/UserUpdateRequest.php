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
        $userId = $this->route('id');

        return [
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'adresse' => 'sometimes|required|string',
            'telephone' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'fonction' => 'sometimes|nullable|string',
            'photo' => 'sometimes|nullable|string',
            'statut' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|string|min:6',
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
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ];
    }
}
