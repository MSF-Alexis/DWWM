<?php
$donneesFormulaire = $_POST;
$email = null;
$retourErreurEmail = null;
if (isset($donneesFormulaire['mail_utilisateur']) && $donneesFormulaire['mail_utilisateur'] !== '') {
    $email = htmlspecialchars($donneesFormulaire['mail_utilisateur']);
    $email = strip_tags($email);
    $email = trim($email);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false ) {
        $retourErreurEmail = "Erreur formulaire : le champ email n'est pas au format d'un email standard";
    }

}
?>


<!DOCTYPE html>
<html lang="72">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 72</title>
</head>

<body>
    <p>
        <?php
        if ($retourErreurEmail !== null) {
            echo $retourErreurEmail;
        } else if ($email !== null) {
            echo "L'email : ".$email." a bien été enregistré !";
        }else {
            echo "Formulaire incomplet pseudo manquant !";
        }
        ?>
    </p>
</body>
</html>


