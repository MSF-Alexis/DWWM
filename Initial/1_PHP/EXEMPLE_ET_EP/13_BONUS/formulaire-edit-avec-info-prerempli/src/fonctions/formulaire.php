<?php

    /**
     * Indique si le champ dans le formulaire existe et s'il n'est pas vide
     *
     * @param $nomDuChamp
     * @return boolean
     */
    function estCeQueLeChampDeFormulairePostExistEtNonVide($nomDuChamp) : bool {
        return isset($_POST[$nomDuChamp]) && !empty($_POST[$nomDuChamp]);
    }

    /**
     * Vérifie si les champs requis du formulaire sont bien remplis 
     *
     * @return bool
     */
    function testerSiLeFormulaireEstRempli() : bool {
        return 
            estCeQueLeChampDeFormulairePostExistEtNonVide('name-input')
            && estCeQueLeChampDeFormulairePostExistEtNonVide('price-input');
    }

    /**
     * On applique toutes les fonctions de nettoyage en un seul
     * coup
     * @param $valeurANettoyer
     * @return mixed
     */
    function nettoyerLaVariable($valeurANettoyer) : mixed {
        return trim(strip_tags(htmlspecialchars($valeurANettoyer)));
    }