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
// Contient la valeur numérique 8
$tailleDuTableauNotesEleve = count($notesEleve);
$cumulDesNotes = 0;
for ($indexNote = 0 ; $indexNote < $tailleDuTableauNotesEleve ; $indexNote++){
    $cumulDesNotes += $notesEleve[$indexNote];
    echo "La note numéro $indexNote est : ".$notesEleve[$indexNote]."<br>";
}
$moyenneGenerale = $cumulDesNotes / $tailleDuTableauNotesEleve;
echo "La moyenne générale de cet élève est de : ".$moyenneGenerale;