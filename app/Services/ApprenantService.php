<?php

namespace App\Services;

use App\Imports\ApprenantsImport;
use App\Jobs\SendActivationEmailJob;
use App\Repositories\ApprenantRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ApprenantService
{
    protected $apprenantRepository;
    protected $firebaseService;

    public function __construct(ApprenantRepository $apprenantRepository, FirebaseService $firebaseService)
    {
        $this->apprenantRepository = $apprenantRepository;
        $this->firebaseService = $firebaseService;
    }

    public function createApprenant(array $data)
    {
        // Vérifier si l'apprenant existe déjà
        $existingApprenant = $this->apprenantRepository->all([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'date_naissance' => $data['date_naissance'],
            'sexe' => $data['sexe']
        ]);

        if (!empty($existingApprenant)) {
            throw new \Exception('Un apprenant avec ces informations existe déjà.');
        }

        // Générer un mot de passe temporaire
        $tempPassword = Str::random(10);
        $data['password'] = Hash::make($tempPassword);

        $id = $this->apprenantRepository->create($data);

        // Envoyer un e-mail avec les informations de connexion
        $this->sendActivationEmail($data['email'], $tempPassword);

        return $id;
    }

    public function getApprenants(array $filters = [])
    {
        return $this->apprenantRepository->all($filters);
    }

    public function getApprenant(string $id)
    {
        $apprenant = $this->apprenantRepository->find($id);

        if (!$apprenant) {
            throw new \Exception('Apprenant non trouvé.');
        }

        return $apprenant;
    }

    public function importApprenants(UploadedFile $file)
    {

        // dd();
        try {
            // $app=new ApprenantsImport($this->firebaseService);
            //             dd($app->model([]));
            $path = str_replace("private", "public", Storage::path($file->store("upload", 'public')));
            $fileApp = Excel::import(new ApprenantsImport($this), $path);

            return [
                'success' => true,
                'message' => 'Importation réussie'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'importation : ' . $e->getMessage()
            ];
        }
    }




    private function sendActivationEmail(string $email, string $password)
    {
        SendActivationEmailJob::dispatch($email, $password);
    }

    public function getInactiveApprenants()
    {
        return $this->apprenantRepository->getInactiveApprenants();
    }

    public function sendActivationReminder(string $id)
    {
        $this->apprenantRepository->sendActivationReminder($id);
    }
    
    public function sendBulkActivationReminder(array $ids)
    {
        foreach ($ids as $id) {
            $apprenant = $this->apprenantRepository->find($id);
            if ($apprenant && !$apprenant['isActive']) { // Vérifier si l'apprenant est inactif
                $this->sendActivationReminder($id);
            }
        }
    }
    
}





