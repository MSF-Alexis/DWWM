<?php 
    $prenom = 'Alexis';
    $dateDuJour = date('d/m/Y - H:i:s');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 59</title>
</head>
<body>
    <h1>Méthode numéro alterner des balises php et html</h1>
    <!-- Methode 1 -->
    <?php 
        echo "<p>Bonjour ".$prenom." bienvenue sur mon site</p>";
        echo "<p>Ajourd'hui nous somme le : ".$dateDuJour."</p>";
    ?>
    <hr>
    <!-- Methode 2 -->
    <?= "<p>Bonjour ".$prenom." bienvenue sur mon site</p>"  ?>
    <?= "<p>Ajourd'hui nous somme le : ".$dateDuJour."</p>" ?>
    <hr>
    <!-- Methode 3 -->
    <?= "<p>Bonjour ".$prenom." bienvenue sur mon site</p><p>Ajourd'hui nous somme le : ".$dateDuJour."</p>"  ?>
</body>
</html>

