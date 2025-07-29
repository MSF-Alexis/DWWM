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
    <title>Exemple 65</title>
</head>

<body>
    <h3>Liste de courses</h3>
    <ul>
        <?php for($i = 0 ; $i < count($listeDeCourse) ; $i++): ?>
            <li><?= $listeDeCourse[$i] ?></li>
        <?php endfor; ?>
    </ul>
</body>

</html>