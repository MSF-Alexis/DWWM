<?php
$texte1 = "<script>alert('Hack!')</script>";
$cleanTexte1 = htmlspecialchars($texte1);
// Affiche : &lt;script&gt;alert(&#039;Hack!&#039;)&lt;/script&gt;
$texte2 = "<p>Bonjour <strong>à tous</strong></p>";
$cleanTexte2 = strip_tags($texte2);
// Résultat : "Bonjour à tous"
$texte3 = "   Bonjour   ";
$cleanTexte3 = trim($text3);
// Résultat : "Bonjour"

