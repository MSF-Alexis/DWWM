<?php

$panierDeFruits = ['Durian', 'Kiwano', 'Pitaya', 'Rambutan'];

// Solution n°1 les brackets vide
$panierDeFruits[] = 'Fraise';

// Solution n°2 la fonction array_push
array_push($panierDeFruits, 'Poire');

echo "<pre>";
print_r($panierDeFruits);
echo"</pre>";

