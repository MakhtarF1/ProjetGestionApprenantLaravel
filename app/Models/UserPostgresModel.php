<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPostgresModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'nom', 'prenom', 'adresse', 'telephone', 'email', 'fonction', 'photo', 'statut', 'role','password'
    ];

    protected $hidden = [
        'password',
    ];


    

}
