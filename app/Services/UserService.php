<?php

namespace App\Services;

use App\Repositories\UserPostgresRepository;
use App\Repositories\UserFirebaseRepository;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Http\UploadedFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $postgresRepository;
    protected $firebaseRepository;

    public function __construct(UserPostgresRepository $postgresRepository, UserFirebaseRepository $firebaseRepository)
    {
        $this->postgresRepository = $postgresRepository;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function getAllUsers($role = null)
    {
        if (env('CONNECTE') === "Firebase") {
            return $this->firebaseRepository->all();
        } else {
            return $this->postgresRepository->all();
        }
    }

    public function createUser(array $data)
    {

        // Debug: Vérifiez le chemin de la photo
        // Vérifiez si 'photo' est présent dans $data
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        } else {
            $data['photo'] = null; // Définir à null si 'photo' n'est pas présent
        }

        $firebaseData = [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'adresse' => $data['adresse'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'fonction' => $data['fonction'] ?? null,
            'photo' => $data['photo'] ?? null, // Assurez-vous que ceci est le chemin correct
            'statut' => $data['statut'] ?? null,
            'password' => bcrypt($data['password']),
        ];


        // Utilisez $data ici pour la création de l'utilisateur PostgreSQL
        $postgresUser = $this->postgresRepository->create($data);
        $firebaseUser = $this->firebaseRepository->create($firebaseData);

        return [
            'postgres' => $postgresUser,
            'firebase' => $firebaseUser,
        ];
    }


    public function createManyUsers(array $usersData)
    {
        $results = [];
        foreach ($usersData as &$userData) {
            if (isset($userData['photo'])) {
                $userData['photo'] = $this->uploadPhoto($userData['photo']);
            }

            $firebaseData = [
                'nom' => $userData['nom'],
                'prenom' => $userData['prenom'],
                'adresse' => $userData['adresse'],
                'telephone' => $userData['telephone'],
                'email' => $userData['email'],
                'fonction' => $userData['fonction'] ?? null,
                'photo' => $userData['photo'] ?? null,
                'statut' => $userData['statut'] ?? null,
                'password' => bcrypt($userData['password'])
            ];

            $postgresUser = $this->postgresRepository->create($userData);
            $firebaseUser = $this->firebaseRepository->create($firebaseData);

            $results[] = [
                'postgres' => $postgresUser,
                'firebase' => $firebaseUser
            ];
        }
        return $results;
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }
        return $this->postgresRepository->update($id, $data);
    }

    public function exportUsers($format, $role = null)
    {
        $users = $this->getAllUsers($role);

        if ($format === 'excel') {
            return Excel::download(new UsersExport($users), 'users.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.users', ['users' => $users]);
            return $pdf->download('users.pdf');
        }

        throw new \InvalidArgumentException("Unsupported export format");
    }

    private function uploadPhoto($photo)
    {
        if ($photo instanceof UploadedFile && $photo->isValid()) {
            try {
                $path = $photo->store('photos', 'public');
                return Storage::url($path);
            } catch (\Exception $e) {
                Log::error('Error uploading photo: ' . $e->getMessage());
                return null;
            }
        }
        return null;
    }
}
