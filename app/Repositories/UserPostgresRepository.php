<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\UserPostgresModel;

class UserPostgresRepository implements UserRepositoryInterface
{
    public function create(array $data): object
    {
        return UserPostgresModel::create($data);
    }

    public function all(): array
    {
        
        return UserPostgresModel::all()->toArray();

    }

    public function find($id): ?object
    {
        return UserPostgresModel::find($id);
    }

    public function update($id, array $data): ?object
    {
        $user = UserPostgresModel::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id): bool
    {
        return UserPostgresModel::destroy($id) > 0;
    }

    public function findByRole($role): array
    {
        return UserPostgresModel::where('role', $role)->get()->toArray();
    }

    public function createMany(array $usersData): array
    {
        return UserPostgresModel::insert($usersData);
    }
}