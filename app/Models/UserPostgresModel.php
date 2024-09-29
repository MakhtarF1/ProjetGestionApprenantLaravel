<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class UserPostgresModel extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'nom', 'prenom', 'adresse', 'telephone', 'email', 'fonction', 'photo', 'statut', 'role', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    // Hachage du mot de passe avant la sauvegarde
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = Hash::make($user->password);
        });

        static::updating(function ($user) {
            if ($user->isDirty('password')) {
                $user->password = Hash::make($user->password);
            }
        });
    }
}
