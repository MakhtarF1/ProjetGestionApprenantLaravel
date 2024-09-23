<?php

namespace App\Services;

use App\Repositories\ReferentielRepository;
use Illuminate\Support\Str;

class ReferentielService
{
    protected $referentielRepository;

    public function __construct(ReferentielRepository $referentielRepository)
    {
        $this->referentielRepository = $referentielRepository;
    }
    public function createReferentiel(array $data)
    {
        // Vérifiez l'unicité dans Firebase
        $existingReferentiels = $this->referentielRepository->all(['code' => $data['code']]);
    
        // Vérifiez si un référentiel existe déjà
        if (!empty($existingReferentiels)) {
            throw new \Exception('Un référentiel avec ce code existe déjà.');
        }
    
        return $this->referentielRepository->create($data);
    }
    
    

    public function getReferentiels(array $filters = [])
    {
        return $this->referentielRepository->all($filters);
    }

    
    public function getReferentiel(string $id, array $filters = [])
    {
        $referentiel = $this->referentielRepository->find($id);

        if (!$referentiel) {
            throw new \Exception('Référentiel non trouvé.');
        }

        if (isset($filters['competence'])) {
            $referentiel = $this->filterCompetences($referentiel);
        }

        if (isset($filters['modules'])) {
            $referentiel = $this->filterModules($referentiel);
        }

        return $referentiel;
    }

    public function updateReferentiel(string $id, array $data)
    {
        $referentiel = $this->referentielRepository->find($id);

        if (!$referentiel) {
            throw new \Exception('Référentiel non trouvé.');
        }

        if (isset($data['competences'])) {
            $referentiel['back'] = array_merge($referentiel['back'], $data['competences']['back'] ?? []);
            $referentiel['front'] = array_merge($referentiel['front'], $data['competences']['front'] ?? []);
        }

        $this->referentielRepository->update($id, $referentiel);
    }

    public function deleteReferentiel(string $id)
    {
        if ($this->referentielRepository->isUsedInActivePromotion($id)) {
            throw new \Exception('Ce référentiel ne peut pas être archivé car il est utilisé dans une promotion en cours.');
        }

        $this->referentielRepository->delete($id);
    }

    public function getArchivedReferentiels()
    {
        return $this->referentielRepository->getArchived();
    }

    private function filterCompetences(array $referentiel): array
    {
        $result = [
            'id' => $referentiel['id'],
            'libelle' => $referentiel['libelle'],
            'competences' => []
        ];

        foreach (['back', 'front'] as $type) {
            foreach ($referentiel[$type] as $competence) {
                $result['competences'][] = [
                    'nom' => $competence['nom'],
                    'description' => $competence['description'],
                    'type' => $type,
                    'modules' => $competence['modules']
                ];
            }
        }

        return $result;
    }

    private function filterModules(array $referentiel): array
    {
        $result = [
            'id' => $referentiel['id'],
            'libelle' => $referentiel['libelle'],
            'modules' => []
        ];

        foreach (['back', 'front'] as $type) {
            foreach ($referentiel[$type] as $competence) {
                foreach ($competence['modules'] as $module) {
                    $result['modules'][] = [
                        'nom' => $module['nom'],
                        'description' => $module['description'],
                        'duree_acquisition' => $module['duree_acquisition'],
                        'competence' => $competence['nom'],
                        'type' => $type
                    ];
                }
            }
        }

        return $result;
    }
}