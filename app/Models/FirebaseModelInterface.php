<?php

namespace App\Models;

interface FirebaseModelInterface {
    public function create(array $data): string; // Retourne l'ID de la nouvelle entrée
    public function save(string $id, array $data): void; // Ne retourne rien
    public function find(string $id): ?array; // Retourne les données ou null si non trouvé
    public function all(): array; // Retourne toutes les entrées
    public function delete(string $id): void; // Ne retourne rien
}
