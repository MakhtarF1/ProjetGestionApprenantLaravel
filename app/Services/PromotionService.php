<?php

namespace App\Services;

use App\Repositories\PromotionRepository;
use App\Models\PromotionModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PromotionService
{
    protected $repository;

    public function __construct(PromotionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createPromotion(array $data): PromotionModel
    {
        $dateDebut = Carbon::parse($data['dateDebut']);
        $dateFin = Carbon::parse($data['dateFin']);
        $dureeEnMois = $dateDebut->diffInMonths($dateFin);

        if ($dureeEnMois < 3) {
            throw new \Exception("La durée de la promotion doit être supérieure à 3 mois.");
        }

        $data['duree'] = $dureeEnMois;
        $data['etat'] = 'Inactif';

        if ($this->repository->getAll()->where('libelle', $data['libelle'])->first()) {
            throw new \Exception("Le libellé de la promotion doit être unique.");
        }

        return $this->repository->create($data);
    }

    public function updatePromotion(string $id, array $data): PromotionModel
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        if (isset($data['dateDebut']) && isset($data['dateFin'])) {
            $dateDebut = Carbon::parse($data['dateDebut']);
            $dateFin = Carbon::parse($data['dateFin']);
            $dureeEnMois = $dateDebut->diffInMonths($dateFin);

            if ($dureeEnMois < 3) {
                throw new \Exception("La durée de la promotion doit être supérieure à 3 mois.");
            }

            $data['duree'] = $dureeEnMois;
        }

        return $this->repository->update($id, $data);
    }

    public function updateReferentiels(string $id, array $referentiels): PromotionModel
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        $promotion->referentiels = $referentiels;
        return $this->repository->update($id, $promotion->toArray());
    }

    public function updateEtat(string $id, string $etat): PromotionModel
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        if ($etat === 'Actif' && $this->repository->getByEtat('Actif')->isNotEmpty()) {
            throw new \Exception("Une promotion est déjà en cours.");
        }

        return $this->repository->update($id, ['etat' => $etat]);
    }

    public function getAllPromotions(): Collection
    {
        return $this->repository->getAll();
    }

    public function getPromotionEncours(): ?PromotionModel
    {
        return $this->repository->getByEtat('Actif')->first();
    }

    public function cloturerPromotion(string $id): PromotionModel
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        if (Carbon::parse($promotion->dateFin)->isFuture()) {
            throw new \Exception("La promotion ne peut pas être clôturée avant sa date de fin.");
        }

        return $this->repository->update($id, ['etat' => 'Cloturer']);
    }

    public function getReferentiels(string $id): array
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        return $promotion->referentiels;
    }

    public function getStats(string $id): array
    {
        $promotion = $this->repository->find($id);
        if (!$promotion) {
            throw new \Exception("Promotion non trouvée.");
        }

        // Implémentez ici la logique pour calculer les statistiques
        // Ceci est un exemple, vous devrez l'adapter à votre structure de données
        return [
            'promotion' => $promotion->toArray(),
            'nbre_apprenant' => count($promotion->apprenants ?? []),
            'nbre_apprenant_actif' => count(array_filter($promotion->apprenants ?? [], function($a) { return $a['statut'] === 'Actif'; })),
            'nbre_apprenant_inactif' => count(array_filter($promotion->apprenants ?? [], function($a) { return $a['statut'] !== 'Actif'; })),
            'referentiels' => array_map(function($r) {
                return [
                    'id' => $r['id'],
                    'libelle' => $r['libelle'],
                    'nbre_apprenant' => count($r['apprenants'] ?? [])
                ];
            }, $promotion->referentiels ?? [])
        ];
    }
}