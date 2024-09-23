<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\UserPostgresModel;
// use App\Services\UserFirebaseService; // Adjust based on your actual service
// use App\Services\UserService;
// use Laravel\Passport\HasApiTokens;

// class AuthController extends Controller
// {
//     use HasApiTokens;

//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);

//         // Determine the authentication method
//         if (env('AUTH_METHOD') === 'firebase') {
//             return $this->loginWithFirebase($request);
//         } else {
//             return $this->loginWithPostgres($request);
//         }
//     }

//     private function loginWithFirebase(Request $request)
//     {
//         $firebaseService = app()->make(UserService::class);
//         $user = $firebaseService->authenticate($request->input('email'), $request->input('password'));

//         if (!$user) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $token = Auth::guard('api')->login($user);
//         return response()->json(['token' => $token, 'user' => $user]);
//     }

//     private function loginWithPostgres(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::attempt($credentials)) {
//             $user = Auth::user();
//             $token = $user->createToken('Personal Access Token')->accessToken;

//             return response()->json(['token' => $token, 'user' => $user]);
//         }

//         return response()->json(['error' => 'Unauthorized'], 401);
//     }


    
// }
