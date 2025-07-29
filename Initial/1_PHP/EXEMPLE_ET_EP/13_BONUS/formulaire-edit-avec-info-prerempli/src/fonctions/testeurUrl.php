<?php
    /**
     * Indique si le paramètre 'id' existe dans l'url et non vide
     *
     * @return boolean
     */
    function estCeQuIlYaUnIdDansLUrl() : bool {
        return isset($_GET['id']) && !empty($_GET['id']);
    }

    /**
     * Indique si le paramètre 'id' dans l'url est bien un nombre
     *
     * @return boolean
     */
    function estCeQueLIdDansLUrlestBienUnNombre() : bool {
        return is_numeric($_GET['id']);
    }

?>