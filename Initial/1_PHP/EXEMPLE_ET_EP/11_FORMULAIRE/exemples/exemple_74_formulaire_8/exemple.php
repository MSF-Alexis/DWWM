<?php
$email = "utilisateur@example.com";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email valide !";
} else {
    echo "Email invalide !";
}

$age = "25";

if (is_numeric($age)) {
    echo "Nombre valide !";
} else {
    echo "Ce n'est pas un nombre !";
}

$url = "https://example.com";

if (filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL valide !";
} else {
    echo "URL invalide !";
}

