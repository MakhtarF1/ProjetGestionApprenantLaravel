<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return collect($this->users)->map(function ($user) {
            return [
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'adresse' => $user['adresse'],
                'telephone' => $user['telephone'],
                'fonction' => $user['fonction'],
                'email' => $user['email'],
                'statut' => $user['statut'],
                'role' => $user['role'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Adresse',
            'Téléphone',
            'Fonction',
            'Email',
            'Statut',
            'Rôle',
        ];
    }
}