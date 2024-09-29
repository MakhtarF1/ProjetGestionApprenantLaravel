<?php
namespace App\Models;

use App\Services\FirebaseService;
use Illuminate\Support\Str;

class PromotionModel extends FirebaseModel
{
    public string $id;
    public string $libelle;
    public string $dateDebut;
    public string $dateFin;
    public int $duree; // Durée en mois
    public string $etat; // Actif, Cloturer, Inactif
    public string $photoCouverture;
    public array $referentiels; // Liste des référentiels associés

    public function __construct(FirebaseService $firebaseService, array $data = [])
    {
        parent::__construct($firebaseService, 'promotions');
        
        $this->id = $data['id'] ?? Str::uuid()->toString();
        $this->libelle = $data['libelle'] ?? '';
        $this->dateDebut = $data['dateDebut'] ?? '';
        $this->dateFin = $data['dateFin'] ?? '';
        $this->duree = $data['duree'] ?? 0;
        $this->etat = $data['etat'] ?? 'Inactif';
        $this->photoCouverture = $data['photoCouverture'] ?? '';
        $this->referentiels = $data['referentiels'] ?? [];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin,
            'duree' => $this->duree,
            'etat' => $this->etat,
            'photoCouverture' => $this->photoCouverture,
            'referentiels' => $this->referentiels,
        ];
    }
}
