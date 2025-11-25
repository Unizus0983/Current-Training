<?php
require_once './models/connect.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Site Simple</title>
    <style>
        body {
            font-family: Arial;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .menu {
            background: #f0f0f0;
            padding: 20px;
            margin: 20px 0;
        }

        a {
            text-decoration: none;
            color: blue;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .user-info {
            background: #e0f7fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <h1>🏠 Mon Site Simple</h1>

    <div class="user-info">
        <strong>Utilisateur :</strong> <?= $user['name'] ?? 'Invité' ?><br>
        <strong>ID Visiteur :</strong> 1
    </div>

    <div class="menu">
        <a href="?page=accueil">Accueil</a> |
        <a href="?page=bonjour">Bonjour</a> |
        <a href="?page=aurevoir">Au revoir</a>
    </div>

    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 'accueil';
    }

    switch ($page) {
        case 'bonjour':
            include('controllers/bonjour.php');  // ← APPEL DU CONTRÔLEUR
            break;

        case 'aurevoir':
            include('controllers/aurevoir.php'); // ← APPEL DU CONTRÔLEUR
            break;

        case 'accueil':
        default:
            echo "<h2>Bienvenue sur mon site !</h2>";
            echo "<p>Choisissez une page dans le menu ci-dessus.</p>";
            break;
    }
    ?>
</body>

</html>