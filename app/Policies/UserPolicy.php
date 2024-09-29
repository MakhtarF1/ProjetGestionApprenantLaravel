<?php

namespace App\Policies;

use App\Models\UserPostgresModel; // Utiliser le bon modèle
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(UserPostgresModel $user, $role)
    {
        Log::info('User Policy create method called', [
            'user_role' => $user->role,
            'requested_role' => $role
        ]);

        if ($user->role === 'admin') {
            return in_array($role, ['admin', 'coach', 'manager', 'cem']);
        }

        if ($user->role === 'manager') {
            return in_array($role, ['coach', 'manager', 'cem']);
        }

        if ($user->role === 'cem') {
            return $role === 'apprenant';
        }

        return false;
    }

    public function update(UserPostgresModel $user, $role)
    {
        if ($user->role === 'admin' || $user->role === 'manager') {
            return true; // Admin et Manager peuvent mettre à jour n'importe quel rôle
        }

        return false; // Autres rôles ne peuvent pas mettre à jour
    }

    public function viewAny(UserPostgresModel $user)
    {
        return true;
    }

    public function export(UserPostgresModel $user)
    {
        return in_array($user->role, ['admin', 'manager', 'cem']);
    }
}
