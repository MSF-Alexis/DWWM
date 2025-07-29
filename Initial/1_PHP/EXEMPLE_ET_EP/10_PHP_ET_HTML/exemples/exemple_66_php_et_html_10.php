<?php
$listeDeCourse = [
    'lait',
    'poisson',
    'pain',
    'haricots vert',
    'oeufs',
    'jus de raisin',
    'riz',
    'yaourts'
];
$index = 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 65</title>
</head>

<body>
    <h3>Liste de courses</h3>
    <ul>
        <?php while($index < count($listeDeCourse)): ?>
            <li><?= $listeDeCourse[$index] ?></li>
            <?php $index++; ?>
        <?php endwhile; ?>
    </ul>
</body>

</html>
