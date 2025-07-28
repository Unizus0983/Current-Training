<?php
session_start();
$host = 'localhost';
$dbname = 'demobdd';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Active les erreurs PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <style>
        body {
            font-size: 1.5rem;
            padding: 150px;
        }

        form {
            max-width: 50vw;
            margin: 0 auto;
            padding: 3rem;
            background-color: #50ddd6ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        input {
            height: 40px;
            width: 200px;
            cursor: pointer;
        }

        .connect {
            border-radius: 12px;
            padding: 0.5rem 0.8rem;
            font-size: 1.2rem;
        }
    </style>

</head>

<body>



    <?php
    if (!isset($_SESSION['user'])) {
        echo '<form method="post">';
        echo '<label>Identifiant</label>';
        echo '<input type="text" name="identifiant" value="' . (isset($_POST['identifiant']) ? htmlspecialchars($_POST['identifiant']) : '') . '">';
        echo '<label>Password</label>';
        echo '<input type="password" name="password" value="">';
        echo '<input type="submit" class="connect" name="submitConnexion" value="Se connecter">';
        echo '<a href="?page=creationAccount">Vous n\'avez pas de compte , Créer un compte !</a>';
        echo '</form>';
    }
    ?>

    <br>
    <?php
    $sql = "SELECT * FROM `users`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($results);

    if (isset($_POST['submitConnexion'])) {
        $sqlCheck = "SELECT * FROM `users` WHERE `adresse_mail_user` = :identifiant";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':identifiant' => $_POST['identifiant']]);
        $user = $stmtCheck->fetch();

        if ($user && password_verify($_POST['password'], $user['password_user'])) {
            $_SESSION['user'] = [
                "id_user" => $user['id_user'],
                "nom_user" => $user['nom_user'],
                "prenom_user" => $user['prenom_user'],
                "age_user" => $user['age_user'],
                "adresse_mail_user" => $user['adresse_mail_user'],
            ];
            echo '<form method="POST">';
            echo '<input type="submit" name="deconnexion" value="Se déconnecter">';
            echo ' </form>';
            echo "<p style='color:green;'>Connexion réussie !</p>";
        } else {
            echo "<p style='color:red;'>Identifiant ou mot de passe incorrect.</p>";
        }
    }
    //DECONNEXION
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        //Après session_destroy(), il est conseillé de rediriger l'utilisateur ou de réinitialiser la page.
        header("Location: index.php");
        exit();
    }
    //UTILISATION DE L'id POUR UNE NOUVELLE PAGE QUI SE RAJOUTE
    if (isset($_GET['page']) && $_GET['page'] == 'creationAccount') {
        echo '<form method="post">';
        echo '<p>Création d\'un compte</p>';
        echo '<input type="text" name="nameCreate" placeholder="Nom" required>';
        echo '<input type="text" name="prenomCreate" placeholder="Prènom" required>';
        echo '<input type="number" name="ageCreate" placeholder="Age" >';
        echo '<input type="email" name="emailCreate" placeholder="Votre adresse mail" required>';
        echo ' <input type="password" name="passwordCreate" placeholder="Entrez votre mot de passe" required>';
        echo '<input type="submit" class ="connect" name=submitCreate value="Créer votre compte">';
        echo '</form>';
    }
    //validation de la creation du compte avec script du mot de pass et verification du mot de passe ci-dessus dans formulaire de connexion
    if (isset($_POST['submitCreate'])) {
        // filepath: c:\xampp\htdocs\demoBDD\index.php
        // ...avant l'insertion...securisation du mot de pass par la fonction hash qui sripte le mot de passe
        $hashedPassword = password_hash($_POST['passwordCreate'], PASSWORD_DEFAULT);
        // valeur ...dans execute...

        $sqlcreate = "INSERT INTO `users` (`nom_user`, `prenom_user`, `age_user`, `adresse_mail_user`, `password_user`) VALUES (:nameCreate, :prenomCreate, :ageCreate, :emailCreate, :passwordCreate);";
        $sqlcreate = $pdo->prepare($sqlcreate);
        $sqlcreate->execute(
            [
                ':nameCreate' => $_POST['nameCreate'],
                ':prenomCreate' => $_POST['prenomCreate'],
                ':ageCreate' => $_POST['ageCreate'],
                ':emailCreate' => $_POST['emailCreate'],
                ':passwordCreate' => $hashedPassword

            ]
        );
        echo "<p style='color:green;'>Compte enregistré !</p>";
    }
    ?>









</body>

</html>