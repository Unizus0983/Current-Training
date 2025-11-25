<?php
// Inclure la classe User si pas déjà fait
require_once './models/connect.php';

$user = User::getFromDatabase(1); // Juste l'ID

// La logique - CORRECTION DES ERREURS
$heure = date('H'); // Juste l'heure, pas la date complète
if ($heure < 12) {
    $message = "Bon matin !";
} elseif ($heure < 18) {
    $message = "Bon après-midi !";
} else {
    $message = "Bonsoir !";
};


// On affiche la vue
include('./view/bonjour.php');
