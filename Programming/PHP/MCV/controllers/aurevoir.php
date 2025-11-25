<?php
// Inclure la classe User si pas déjà fait
require_once './models/connect.php';

$user = User::getFromDatabase(1); // Juste l'ID

// La logique
$messages = [
    "Merci de votre visite !",
    "À bientôt j'espère !",
    "Portez-vous bien !",
    "Bonne journée !"
];
$message = $messages[array_rand($messages)];

// On affiche la vue
include('./view/aurevoir.php');
