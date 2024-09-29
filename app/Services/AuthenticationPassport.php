<?php

namespace App\Services;

use App\Models\UserPostgresModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticationPassport 
{
    public function authenticate(array $credentials): JsonResponse
    {
        $user = UserPostgresModel::where('email', $credentials['email'])->first(); // Utilisation de l'email

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Mot de passe incorrect'], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token', ['*'], [
            'id' => $user->id,
            'role' => $user->role, // Assurez-vous que le rôle est accessible
            'photo' => $user->photo,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email, // Changement de login à email
            'statut' => $user->statut,
        ]);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => $tokenResult->token->expires_at->diffInSeconds(now()),
        ], 200);
    }

  
    
    
}
