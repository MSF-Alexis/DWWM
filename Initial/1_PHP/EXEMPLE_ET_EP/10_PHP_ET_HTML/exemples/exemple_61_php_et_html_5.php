<?php 
   $ageUtilisateur = 16;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 61</title>
</head>
<body>
    <h1>Casino</h1>
    <?php if ($ageUtilisateur > 17) : ?>
        <h4> Bienevnue sur le site du casino </h4>
    <?php else: ?>
        <p>Vous n'avez pas l'âge requis pour venir jouer ici</p>
        <a href='https://www.google.com'> Faire demi-tour</a>
    <?php endif; ?>
</body>
</html>

