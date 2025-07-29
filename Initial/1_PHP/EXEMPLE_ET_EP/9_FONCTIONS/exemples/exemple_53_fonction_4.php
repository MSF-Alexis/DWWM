<?php

function multiplicationDeAParB($a, $b) {
    return $a * $b;
}

function mettreUnNombreAuCarre($nombreAMettreAuCarre) {
    return multiplicationDeAParB($nombreAMettreAuCarre, $nombreAMettreAuCarre);
}

echo mettreUnNombreAuCarre(4);