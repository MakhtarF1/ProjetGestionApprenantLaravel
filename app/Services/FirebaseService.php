<?php

namespace App\Services;

use App\Models\UserFirebaseModel;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\AuthException;

class FirebaseService
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        
dd('ok');
        $credentialsFile = '/home/anonima/GestionEcoleLaravel1/credentials.json';
        $databaseUrl = 'https://gestion-ecolestore-default-rtdb.firebaseio.com/';

        if (!file_exists($credentialsFile)) {
            throw new \InvalidArgumentException('Le fichier de credentials Firebase est introuvable.');
        }

        $factory = (new Factory)
            ->withServiceAccount($credentialsFile)
            ->withDatabaseUri($databaseUrl);

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function signInWithEmailAndPassword(string $email, string $password)
    {
        try {
            return $this->auth->signInWithEmailAndPassword($email, $password);
        } catch (AuthException $e) {
            throw new \Exception('Erreur d\'authentification, veuillez réessayer.');
        }
    }

    public function verifyIdToken(string $idToken)
    {
        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (FailedToVerifyToken $e) {
            throw new \Exception('Token d\'identification invalide.');
        }
    }

    public function getUser(string $uid)
    {
        try {
            return $this->auth->getUser($uid);
        } catch (AuthException $e) {
            throw new \Exception('Erreur lors de la récupération de l\'utilisateur.');
        }
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setData(string $path, array $data)
    {
        try {
            $this->database->getReference($path)->set($data);
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de l\'écriture dans la base de données.');
        }
    }

    public function getData(string $path)
    {
        try {
            return $this->database->getReference($path)->getValue();
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la lecture de la base de données.');
        }
    }

    public function getUserByEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email non valide.');
        }

        try {
            $userData = $this->database->getReference('users')->orderByChild('email')->equalTo($email)->getSnapshot()->getValue();

            if (!empty($userData) && is_array($userData)) {
                $user = reset($userData);
                return new UserFirebaseModel(
                    $this,
                    $user['nom'],
                    $user['prenom'],
                    $user['adresse'],
                    $user['telephone'],
                    $user['email'],
                    $user['fonction'],
                    $user['photo'],
                    $user['statut'],
                    $user['password']
                );
            }
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la récupération de l\'utilisateur par email.');
        }

        return null; // Return null if no user is found
    }
}
