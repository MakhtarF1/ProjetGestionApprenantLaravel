<?php

namespace App\Models;

use App\Services\FirebaseService;
use App\Models\FirebaseModelInterface;

abstract class FirebaseModel implements FirebaseModelInterface
{
    protected string $collection;
    protected FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService, string $collection)
    {
        $this->firebaseService = $firebaseService;
        $this->collection = $collection;
    }
    

    // Crée une nouvelle entrée dans la collection
    public function create(array $data): string
    {
        $newRef = $this->firebaseService->getDatabase()->getReference($this->collection)->push($data);
        return $newRef->getKey(); // Retourne l'ID de la nouvelle entrée
    }

    // Récupère toutes les entrées
    public function all(): array
    {
        $snapshot = $this->firebaseService->getDatabase()->getReference($this->collection)->getSnapshot();
        return $snapshot->exists() ? $snapshot->getValue() : [];
    }

    // Récupère une entrée par son ID
    public function find(string $id): ?array
    {
        $snapshot = $this->firebaseService->getDatabase()->getReference($this->collection)->getChild($id)->getSnapshot();
        return $snapshot->exists() ? $snapshot->getValue() : null; // Retourne les données ou null si non trouvé
    }

    // Met à jour une entrée existante
    public function save(string $id, array $data): void
    {
        $this->firebaseService->getDatabase()->getReference($this->collection)->getChild($id)->set($data);
    }

    // Supprime une entrée par son ID
    public function delete(string $id): void
    {
        $this->firebaseService->getDatabase()->getReference($this->collection)->getChild($id)->remove();
    }

    // Méthode abstraite pour convertir l'objet en tableau (à implémenter dans les classes dérivées)
    abstract public function toArray(): array;
}
