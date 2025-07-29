<?php
$donneesFormulaire = $_POST;
$email = null;
if (isset($donneesFormulaire['mail_utilisateur']) && $donneesFormulaire['mail_utilisateur'] !== '') {
    
    $email = htmlspecialchars($donneesFormulaire['mail_utilisateur']);
    $email = strip_tags($email);
    $email = trim($email);
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
        if ($pseudo !== null) {
            echo "Votre mail " . $mail . " a bien été enregistré !";
        } else {
            echo "Formulaire incomplet pseudo manquant !";
        }
        ?>
    </p>
</body>
</html>


