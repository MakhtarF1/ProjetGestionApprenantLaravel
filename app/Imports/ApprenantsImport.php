<?php
namespace App\Imports;

use App\Services\ApprenantService;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class ApprenantsImport implements ToModel
{
    protected ApprenantService $firebaseService;
    public function __construct(ApprenantService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {

        $data = [
            'nom'         => $row[0],
            'prenom'        => $row[1],
            'adresse'       => $row[2],
            'telephone'     => $row[3],
            'email'        => $row[4],
            'photo'        => $row[5],
            'referentiel'  => $row[6],
            'date_naissance'    => $row[7],
            'sexe'    => $row[8],
        ];
        if ($data["nom"] == "nom" && $data["adresse"] == "adresse")
            return;
        Log::info("Test from userimport", $data);
        $this->firebaseService->createApprenant($data);

    }
}