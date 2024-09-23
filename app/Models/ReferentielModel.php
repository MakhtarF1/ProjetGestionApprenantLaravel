<?php

namespace App\Models;

use App\Services\FirebaseService;

class ReferentielModel extends FirebaseModel
{
    protected string $collection = 'referentiels';

    public string $libelle;
    public string $etat; // Actif, Inactif, Archiver
    public array $back; // Liste des compétences côté back
    public array $front; // Liste des compétences côté front
    public array $apprenants; // Liste des apprenants associés

    public function __construct(FirebaseService $firebaseService, string $libelle, string $etat, array $back = [], array $front = [], array $apprenants = [])
    {
        parent::__construct($firebaseService, $this->collection);
        $this->libelle = $libelle;
        $this->etat = $etat;
        $this->back = $back;
        $this->front = $front;
        $this->apprenants = $apprenants;
    }

    public function toArray(): array
    {
        return [
            'libelle' => $this->libelle,
            'etat' => $this->etat,
            'back' => $this->back,
            'front' => $this->front,
            'apprenants' => $this->apprenants,
        ];
    }
}
