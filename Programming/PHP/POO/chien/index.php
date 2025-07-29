<?php

require_once './class/chien.php';
echo "coucou";
echo "<hr>";

// Utilisation de la classe
$chien1 = new Chien("Rex", "Berger Allemand");

echo "Nom : " . $chien1->getNom() . "<br>";

echo "Race : " . $chien1->getRace() . "<br>";

//  Changement de nom
$chien1->setNom("Max");

// // Faire aboyer le chien
$chien1->aboyer();
