<?php

namespace App\Models;

use App\Services\FirebaseService;
use Laravel\Passport\HasApiTokens;

class UserFirebaseModel extends FirebaseModel
{
    use HasApiTokens;
    protected string $collection = 'users';

    public ?string $nom = null;
    public ?string $prenom = null;
    public ?string $adresse = null;
    public ?string $telephone = null;
    public ?string $email = null;
    public ?string $fonction = null;
    public ?string $photo = null;
    public ?string $statut = null;
    public ?string $password = null;

    public function __construct(FirebaseService $firebaseService = null, array $attributes = [])
    {
        if ($firebaseService) {
            parent::__construct($firebaseService, $this->collection);
        }
        
        $this->fill($attributes);
    }

    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public static function createWithAttributes(FirebaseService $firebaseService, array $attributes): self
    {
        return new self($firebaseService, $attributes);
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
        ];
    }


    
}