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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple 64</title>
</head>

<body>
    <h3>Liste de courses</h3>
    <ul>
        <?php foreach($listeDeCourse as $itemDeCourse): ?>
            <li><?= $itemDeCourse ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
