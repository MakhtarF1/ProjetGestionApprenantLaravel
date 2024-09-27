<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;

class FirebaseAuthService
{
    protected $auth;

    public function __construct()
    {
        $this->auth = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->createAuth();
    }

    public function createUser($email, $password)
    {
        return $this->auth->createUserWithEmailAndPassword($email, $password);
    }

    public function signIn($email, $password)
    {
        return $this->auth->signInWithEmailAndPassword($email, $password);
    }

    public function verifyToken($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }
}
