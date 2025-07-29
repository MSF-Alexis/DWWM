<?php
$notesEleve = [
    15,
    13,
    17,
    8,
    4,
    19,
    11,
    10.5,
];

$cumulDesNotes = 0;
foreach ($notesEleve as $indexNote => $note) {
    $cumulDesNotes += $note;
    echo "La note numéro $indexNote est : ".$note."<br>";
}

$moyenneGenerale = $cumulDesNotes / count($notesEleve);
echo "La moyenne générale de cet élève est de : ".$moyenneGenerale;

