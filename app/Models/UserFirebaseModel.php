<?php

namespace App\Models;

use App\Services\FirebaseService;

class UserFirebaseModel extends FirebaseModel
{
    protected string $collection = 'users';

    public string $nom;
    public string $prenom;
    public string $adresse;
    public string $telephone;
    public string $email;
    public ?string $fonction; // Fonction peut être null
    public ?string $photo; // Photo peut être null
    public ?string $statut; // Statut peut être null
    public string $password;

    public function __construct(FirebaseService $firebaseService, string $nom, string $prenom, string $adresse, string $telephone, string $email, ?string $fonction = null, ?string $photo = null, ?string $statut = null, string $password)
    {
        parent::__construct($firebaseService, $this->collection);
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->fonction = $fonction;
        $this->photo = $photo;
        $this->statut = $statut;
        $this->password = $password;
    }

    public function toArray(): array
    {
        return [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'fonction' => $this->fonction,
            'photo' => $this->photo,
            'statut' => $this->statut,
            'password' => $this->password, // Ne pas exposer le mot de passe dans la réponse
        ];
    }
}
