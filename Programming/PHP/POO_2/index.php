<?php

require_once './Classes/compte.php';

$compte = new Compte("Benoit", 500);
echo $compte->voirSolde();
echo "<hr>";

$compte->setTitulaire('arthur');

echo "<hr>";
$compte->setSolde(200);


$compte->deposer(100);
echo "<br>" . $compte->voirSolde();
echo "<hr>";


echo "<br>" . $compte->retirer(100);
echo "<hr>";

echo "<br>" . $compte->voirSolde();
