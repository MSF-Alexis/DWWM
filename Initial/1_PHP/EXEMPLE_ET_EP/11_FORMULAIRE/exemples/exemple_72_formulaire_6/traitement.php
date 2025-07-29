<?php 
    $donneesFormulaire = $_POST;
    $pseudo = null;
    if (isset($donneesFormulaire['pseudo']) && $donneesFormulaire['pseudo'] !== ''){
       $pseudo = $donneesFormulaire['pseudo'];
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
                echo "Votre pseudo ".$pseudo." a bien été enregistré !";
            }else{
                echo "Formulaire incomplet pseudo manquant !";
            }
        ?>
    </p>
</body>
</html>

