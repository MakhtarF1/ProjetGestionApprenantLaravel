<?php

// namespace App\Services;

// use App\Models\UserFirebaseModel;
// use App\Models\UserPostgresModel;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Validator;

// class AuthService implements AuthServiceInterface
// {
//     protected $firebaseService;

//     public function __construct(FirebaseService $firebaseService)
//     {
//         $this->firebaseService = $firebaseService;
//     }

//     public function authenticate(array $credentials): JsonResponse
//     {
//         // Valider les informations d'identification
//         $validator = Validator::make($credentials, [
//             'email' => 'required|string', // Assurez-vous que le champ est 'email'
//             'password' => 'required|string',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['error' => $validator->errors()], 400);
//         }

//         $driver = env('AUTHENTICATION_DRIVER');

//         if ($driver === 'firebase') {
//             // Authentification avec Firebase
//             $user = $this->firebaseService->getUserByEmail($credentials['email']); // Utilisez 'email'

//             if (!$user) {
//                 return response()->json(['error' => 'Utilisateur non trouvé'], 404);
//             }

//             // Vérifiez le mot de passe avec Firebase
//             // Remarque : Vous ne devriez pas vérifier le mot de passe ici, utilisez Firebase pour l'authentification.
//             // if (!Hash::check($credentials['password'], $user->password)) {
//             //     return response()->json(['error' => 'Mot de passe incorrect'], 401);
//             // }

//             // Authentification avec Firebase ici
//             try {
//                 $firebaseUser = $this->firebaseService->authenticateWithFirebase($credentials['email'], $credentials['password']);
//             } catch (\Exception $e) {
//                 return response()->json(['error' => $e->getMessage()], 401);
//             }
//         } elseif ($driver === 'pgsql') {
//             // Authentification avec PostgreSQL
//             $user = UserPostgresModel::where('email', $credentials['email'])->first();

//             if (!$user) {
//                 return response()->json(['error' => 'Utilisateur non trouvé'], 404);
//             }

//             if (!Hash::check($credentials['password'], $user->password)) {
//                 return response()->json(['error' => 'Mot de passe incorrect'], 401);
//             }
//         } else {
//             return response()->json(['error' => 'Driver d\'authentification non supporté'], 400);
//         }

//         // Création du token d'accès
//         $tokenResult = $user->createToken('Personal Access Token', ['*'], [
//             'id' => $user->id,
//             'role' => $user->role ?? null,
//             'photo' => $user->photo,
//             'nom' => $user->nom,
//             'prenom' => $user->prenom,
//             'email' => $user->email,
//             'etat' => $user->statut ?? null,
//             'role_id' => $user->role_id ?? null,
//         ]);

//         return response()->json([
//             'access_token' => $tokenResult->accessToken,
//             'expires_in' => $tokenResult->token->expires_at->diffInSeconds(now()),
//         ], 200);
//     }
// }
