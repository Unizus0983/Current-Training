// $host = 'localhost';
//$dbname = 'rpg';
//$user = 'root';
//$password = '';

// try {
// $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
// Active les erreurs PDO en exception
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo "Connexion réussie !";
// } catch (PDOException $e) {
// echo "Erreur de connexion : " . $e->getMessage();
// }



//

<?php

// Connexion à la BDD
$host = 'localhost';
$dbname = 'rpg';
$user = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête SQL
$sql = "SELECT * FROM `personnage`";

// Préparation + Execution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Réponse - Exploitation des données
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Manière 1

foreach ($results as $key => $value) {

    echo 'idPersonnage : ' . $value['idPersonnage'] . '<br>';
    echo 'nom : ' . $value['nom'] . '<br>';
    echo 'surnom : ' . $value['surnom'] . '<br>';
    echo 'level : ' . $value['level'] . '<br>';
    echo 'idArmeUtilise : ' . $value['idArmeUtilise'] . '<br>';
    echo 'idClasse : ' . $value['idClasse'] . '<br>';

    // foreach ($value as $key2 => $value2) {
    //     echo $key2 . " : " . $value2;
    //     echo '<br>';
    // }

    echo "<br>";
    echo "<br>";
}


// Manière 2
//     foreach ($results as $key => $value) {

//     foreach ($value as $key2 => $value2) {
//         echo $key2 . " : " . $value2;
//         echo '<br>';
//     }

//     echo "<br>";
//     echo "<br>";
// }


?>