<?php

$panierDeFruits = ['Durian', 'Kiwano', 'Pitaya', 'Rambutan', 'Fraise', 'Poire'];

// Solution n°1 les brackets vide
array_splice($panierDeFruits, 2, 1);
// Solution n°2 la fonction array_push
unset($panierDeFruits[2]);

echo "<pre>";
print_r($panierDeFruits);
echo"</pre>";

