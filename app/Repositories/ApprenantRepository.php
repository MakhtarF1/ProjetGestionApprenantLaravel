<?php

namespace App\Repositories;

use App\Facades\ApprenantFacade;
use App\Models\ApprenantModel;
use App\Services\FirebaseService;
use App\Services\QrCodeService; // Importer le service
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ApprenantsImport;

class ApprenantRepository
{
    protected $firebaseService;
    protected $qrCodeService; // Déclarer le service QR

    public function __construct(FirebaseService $firebaseService, QrCodeService $qrCodeService)
    {
        $this->firebaseService = $firebaseService;
        $this->qrCodeService = $qrCodeService; // Initialiser le service
    }

    public function create(array $data): string
    {
        $data['matricule'] = $this->generateMatricule();
        $data['qrCode'] = $this->qrCodeService->generateQrCode(json_encode([
            'matricule' => $data['matricule'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
        ]));
        $data['isActive'] = false;
        
        return ApprenantFacade::create($data);
    }

    public function all(array $filters = []): array
    {
        $apprenants = ApprenantFacade::all();

        if (!empty($filters)) {
            $apprenants = array_filter($apprenants, function ($apprenant) use ($filters) {
                foreach ($filters as $key => $value) {
                    if ($apprenant[$key] != $value) {
                        return false;
                    }
                }
                return true;
            });
        }

        return $apprenants;
    }

    public function find(string $id): ?array
    {
        return ApprenantFacade::find($id);
    }

    public function update(string $id, array $data): void
    {
        ApprenantFacade::save($id, $data);
    }

    public function delete(string $id): void
    {
        ApprenantFacade::delete($id);
    }

    private function generateMatricule(): string
    {
        return 'MAT-' . Str::random(8);
    }


    public function getInactiveApprenants(): array
    {
        return array_filter(ApprenantFacade::all(), function ($apprenant) {
            return !$apprenant['isActive'];
        });
    }

    public function sendActivationReminder(string $id): void
    {
        $apprenant = $this->find($id);
        if ($apprenant) {
            // Logic to send an email or notification
        }
    }
}
