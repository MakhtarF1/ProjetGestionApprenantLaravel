<?php

namespace App\Services;

use App\Repositories\UserPostgresRepository;
use App\Repositories\UserFirebaseRepository;

class UserService
{
    protected UserPostgresRepository $postgresRepository;
    protected UserFirebaseRepository $firebaseRepository;

    public function __construct(UserPostgresRepository $postgresRepository, UserFirebaseRepository $firebaseRepository)
    {
        $this->postgresRepository = $postgresRepository;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function createUser(array $data)
    {
        $postgresUser = $this->postgresRepository->create($data);
        $firebaseUser = $this->firebaseRepository->create($data);

        return [
            'postgres' => $postgresUser,
            'firebase' => $firebaseUser,
        ];
    }

    public function getAllUsers($role = null)
    {
        if (env('CONNECT') === 'firebase') {
            $firebaseUsers = $this->firebaseRepository->all();
            return $role ? array_filter($firebaseUsers, fn($user) => $user['role'] === $role) : $firebaseUsers;
        } else {
            $postgresUsers = $this->postgresRepository->all();
            return $role ? array_filter($postgresUsers, fn($user) => $user['role'] === $role) : $postgresUsers;
        }
    }

    public function findUser($id)
    {
        $postgresUser = $this->postgresRepository->find($id);
        $firebaseUser = $this->firebaseRepository->find($id);

        return [
            'postgres' => $postgresUser,    
            'firebase' => $firebaseUser,
        ];
    }

    public function updateUser($id, array $data)
    {
        $postgresUser = $this->postgresRepository->save($id, $data);
        $firebaseUser = $this->firebaseRepository->save($id, $data);

        return [
            'postgres' => $postgresUser,
            'firebase' => $firebaseUser,
        ];
    }

    public function deleteUser($id)
    {
        $postgresResult = $this->postgresRepository->delete($id);
        $firebaseResult = $this->firebaseRepository->delete($id);

        return [
            'postgres' => $postgresResult,
            'firebase' => $firebaseResult,
        ];
    }
}
