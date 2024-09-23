<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class AuthController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            // Authentification via Firebase
            $signInResult = $this->firebaseService->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            $idToken = $signInResult->idToken();

            // Vérification du token Firebase
            $verifiedIdToken = $this->firebaseService->verifyIdToken($idToken);

            // Récupération de l'UID de l'utilisateur
            $uid = $verifiedIdToken->claims()->get('sub');

            // Obtenir les informations de l'utilisateur Firebase
            $user = $this->firebaseService->getUser($uid);

            return response()->json([
                'message' => 'Connexion réussie',
                'user' => $user,
                'token' => $idToken,
            ]);
        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => 'Échec de la vérification du token Firebase'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Échec de la connexion : ' . $e->getMessage()], 500);
        }
    }
}
