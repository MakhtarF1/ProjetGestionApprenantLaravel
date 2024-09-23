<?php

namespace App\Policies;

use App\Models\UserPostgresModel;
use App\Models\UserFirebaseModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(UserPostgresModel $user)
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function update(UserPostgresModel $user, UserPostgresModel $model)
    {
        return $user->role === 'admin' || ($user->role === 'manager' && in_array($model->role, ['coach', 'cm']));
    }

    public function delete(UserPostgresModel $user, UserPostgresModel $model)
    {
        return $user->role === 'admin';
    }

    public function viewAny(UserPostgresModel $user)
    {
        return in_array($user->role, ['admin', 'manager', 'cm']);
    }

    public function view(UserPostgresModel $user, UserPostgresModel $model)
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }
}
