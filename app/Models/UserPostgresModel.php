<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

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
}