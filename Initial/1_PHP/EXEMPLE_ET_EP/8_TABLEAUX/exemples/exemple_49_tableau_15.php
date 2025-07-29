<?php
$classe = [
    [
        'prenom' => 'Jonathan',
        'notes' => [
            13, 10, 6
        ],
    ],
    [
        'prenom' => 'Anthonin',
        'notes' => [
            12, 20, 4
        ],
    ],
    [
        'prenom' => 'Julien',
        'notes' => [
            8, 6, 5
        ],
    ],
    [
        'prenom' => 'Carlo',
        'notes' => [
            14, 17, 10
        ],
    ],
];
// On boucle sur chaque élève disponnible dans le tableau parent
foreach ($classe as $index => $eleve) {
    $noteAccumulator = 0;
    // On boucle sur chaque note
    foreach ($eleve['notes'] as $note) {
        $noteAccumulator+= $note;
    }
    // On ajoute une nouvel clé dans chaquel élève pour ajouter la moyenne
    $classe[$index]['moyenne'] = $noteAccumulator / count($eleve['notes']);
}
echo '<pre>';
print_r($classe);
echo '</pre>';
?>


<table>
    <tr>
        <th>Prénom</th>
        <th>Notes</th>
        <th>Moyenne</th>
    </tr>
    <tbody>
    <?php
        foreach ($classe as $eleve) {
            echo '<tr>';
            echo '<td>'.$eleve['prenom'].'</td>';
            echo '<td>';
            foreach ($eleve['notes'] as $note) {
                echo $note." ";
            }
            echo '</td>';
            echo '<td>'.$eleve['moyenne'].'</td>';
            echo '</tr>';
        }
    ?>
    </tbody>
</table>

