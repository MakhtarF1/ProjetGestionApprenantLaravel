<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\UserPostgresModel;

class UserPostgresRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return UserPostgresModel::create($data);
    }

    public function all()
    {
        return UserPostgresModel::all()->toArray(); // Convert to array
    }

    public function find($id)
    {
        return UserPostgresModel::find($id);
    }

    public function save($id, array $data)
    {
        $user = UserPostgresModel::find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null; // Return null if user not found
    }

    public function delete($id)
    {
        return UserPostgresModel::destroy($id);
    }
}
