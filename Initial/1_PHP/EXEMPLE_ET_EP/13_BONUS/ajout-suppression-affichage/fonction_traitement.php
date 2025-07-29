<?php 
    function verifierSiChampExisteEtNonVide($cle) {
        return isset($_POST[$cle]) && !empty($_POST[$cle]);
    }

    function nettoyerLaVariable($cle) {
        return  trim(strip_tags(htmlspecialchars($cle)));
    }

    function verifierSiCestUnEmailValide($valeurEmail) {
        return filter_var($valeurEmail, FILTER_VALIDATE_EMAIL);
    }

?>