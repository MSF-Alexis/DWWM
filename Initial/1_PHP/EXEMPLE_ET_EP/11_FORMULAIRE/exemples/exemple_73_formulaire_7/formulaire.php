<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 72</title>
    <style>
        input {
            border : 1px solid;
            display: block;
            width: 10%;
            margin: 10px 0px;
        }
    </style>
</head>
<body>
    <form action="./traitement.php" method="POST">
        <label for="">Pseudo</label>
        <input type="text" name="pseudo">
        <label for="">Email</label>
        <input type="email" name="mail_utilisateur" required>
        <label for="">Mot de passe</label>
        <input type="password" name="mot_de_passe" required>
        <input type="submit" value="Envoyer" name="submit_button">
    </form>
</body>
</html>
