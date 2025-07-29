<?php
$ilFaitBeau = true;
$jaiFiniLeTravail = false;
var_dump($ilFaitBeau && $jaiFiniLeTravail);

$jaimeLesPates = true;
$jaimeLesHuitres = false;
var_dump($jaimeLesPates || $jaimeLesHuitres);

// Piège à éviter, ne pas reproduire !!!
var_dump(true && "hello"); // true (PHP convertit "hello" en true)
var_dump(true && ""); // false (PHP convertit "" en false)