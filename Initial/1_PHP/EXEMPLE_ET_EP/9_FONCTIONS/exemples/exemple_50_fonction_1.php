<?php
    // Premier temps on écrit la recette
    function addition($nombre1, $nombre2){
        $resultat = $nombre1 + $nombre2;
        return $resultat;
    }

    // Second temps on appllique la recette avec nos quantités
    echo addition(55, 33);
?>