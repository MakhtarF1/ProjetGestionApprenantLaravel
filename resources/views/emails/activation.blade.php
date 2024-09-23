<!DOCTYPE html>
<html>
<head>
    <title>Activation de votre compte</title>
</head>
<body>
    <h1>Bienvenue !</h1>
    <p>Votre compte a été créé avec succès. Voici vos informations de connexion :</p>
    <p>Email : {{ $email }}</p>
    <p>Mot de passe temporaire : {{ $password }}</p>
    <p>Veuillez vous connecter et changer votre mot de passe dès que possible.</p>
    <a href="{{ url('/login') }}">Se connecter</a>
</body>
</html>