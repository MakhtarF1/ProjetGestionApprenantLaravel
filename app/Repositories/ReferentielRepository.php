<?php

namespace App\Repositories;

use App\Facades\ReferentielFacade;
use App\Models\ReferentielModel;
use App\Services\FirebaseService;

class ReferentielRepository
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function create(array $data): string
    {
        return ReferentielFacade::create($data);
    }

    public function all(array $filters = []): array
    {
        
        $referentiels = ReferentielFacade::all();

        if (!empty($filters)) {
         
            $referentiels = array_filter($referentiels, function ($referentiel) use ($filters) {
           
                foreach ($filters as $key => $value) {
                  
                    // Ajoutez une vérification ici
                    if (!isset($referentiel[$key]) || $referentiel[$key] != $value) {
                        return false;
                    }
                }
            
                return true;
            });
        }
    
        return $referentiels;
    }
    
    
    public function find(string $id): ?array
    {
        return ReferentielFacade::find($id);
    }

    public function update(string $id, array $data): void
    {
        ReferentielFacade::save($id, $data);
    }

    public function delete(string $id): void
    {
        $referentiel = $this->find($id);
        if ($referentiel) {
            $referentiel['etat'] = 'Archiver';
            $this->update($id, $referentiel);
        }
    }

    public function getArchived(): array
    {
        return $this->all(['etat' => 'Archiver']);
    }

    public function isUsedInActivePromotion(string $id): bool
    {
        // Cette méthode devrait vérifier si le référentiel est utilisé dans une promotion en cours
        // Pour l'instant, nous retournons false, mais vous devrez implémenter la logique réelle
        return false;
    }
}