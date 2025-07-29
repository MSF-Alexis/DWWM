<?php
$couleur = 'red';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 62</title>
</head>

<body>
    <?php if ($couleur == 'green') : ?>
        <h4 style="color: green"> Hello world </h4>
    <?php elseif ($couleur == 'blue'): ?>
        <h4 style="color: blue"> Hello world </h4>
    <?php elseif ($couleur == 'purple'): ?>
        <h4 style="color: purple"> Hello world </h4>
    <?php else : ?>
        <h4 style="color:red;">Hello world</h4>
    <?php endif; ?>
</body>

</html>

