<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Fonction</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user['nom'] }}</td>
                    <td>{{ $user['prenom'] }}</td>
                    <td>{{ $user['adresse'] }}</td>
                    <td>{{ $user['telephone'] }}</td>
                    <td>{{ $user['fonction'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['statut'] }}</td>
                    <td>{{ $user['role'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>