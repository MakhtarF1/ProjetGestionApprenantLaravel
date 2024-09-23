<?php

namespace App\Models;

use App\Services\FirebaseService;

class ApprenantModel extends FirebaseModel
{
    protected string $collection = 'apprenants';

    public string $nom;
    public string $prenom;
    public string $adresse;
    public string $telephone;
    public string $email;
    public string $photo;
    public string $referentiel;
    public array $presences;
    public array $notes;
    public bool $isActive;
    public string $matricule; // Nouveau champ
    public string $qrCode; // Nouveau champ

    public function __construct(FirebaseService $firebaseService, string $nom, string $prenom, string $adresse, string $telephone, string $email, string $photo, string $referentiel, string $matricule, string $qrCode, array $presences = [], array $notes = [], bool $isActive = false)
    {
        parent::__construct($firebaseService, $this->collection);
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->photo = $photo;
        $this->referentiel = $referentiel;
        $this->matricule = $matricule;
        $this->qrCode = $qrCode;
        $this->presences = $presences;
        $this->notes = $notes;
        $this->isActive = $isActive;
    }

    public function toArray(): array
    {
        return [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'photo' => $this->photo,
            'referentiel' => $this->referentiel,
            'matricule' => $this->matricule,
            'qrCode' => $this->qrCode,
            'presences' => $this->presences,
            'notes' => $this->notes,
            'isActive' => $this->isActive,
        ];
    }
}
