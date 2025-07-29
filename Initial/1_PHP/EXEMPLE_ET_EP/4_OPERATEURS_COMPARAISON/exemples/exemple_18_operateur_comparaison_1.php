<?php
// Note : à partir de maintenant pour vérifier nos executions nous allons utiliser var_dump au lieu de echo
// Car echo false n'affichera rien sur votre navigateur
var_dump(1 == 2);
echo "<br>";
var_dump(1 == "1"); // (conversion de type)
echo "<br>";
var_dump(1 != "1"); // (conversion de type)
echo "<br>";
var_dump("hello" == "hello"); 
echo "<br>";
var_dump("hello" == "HELLO");
echo "<br>";
var_dump(0 == false);  //(conversion de type)
echo "<br>";
var_dump("" == false);  //(conversion de type)

