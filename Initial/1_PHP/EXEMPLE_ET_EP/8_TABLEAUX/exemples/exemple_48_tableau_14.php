<?php

$classes = [
    ['Jonathan', 13, 10 , 6],
    ['Anthonin', 12, 20, 4],
    ['Julien', 8, 6, 5],
    ['Carlo', 14, 17, 10]
];

echo '<ul>';
foreach ($classes as $index => $eleve) {
    foreach ($eleve as $cle => $valeur){
        echo '<li>'.$cle.'=>'.$valeur.'</li>';
    }
}
echo '</ul>';