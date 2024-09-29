<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'fonction' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'statut' => 'nullable|string|max:50',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
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
            'role.required' => 'Le rôle est requis.',
            'role.in' => 'Le rôle doit être l\'un des suivants : admin, coach, manager, cm.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ];
    }
}
