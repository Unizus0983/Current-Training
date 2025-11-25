<?php
//constantes
$host = 'localhost';
$dbname = 'mcvdemo';
$user = 'root';
$password = '';
//connexion à la base
try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //on definit dés le début la connexion le mode de 'fetch' par défaut 
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // REQUÊTE DIRECTE POUR ID 1
    // DONNE LA CONNEXION À LA CLASSE USER
    require_once 'users.php';
    User::setConnection($pdo);

    echo 'connexion réussie !';
} catch (PDOException $e) {
    die("erreur de connexion !" . $e->getMessage());
}
