<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'library';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Récupération de l'ID du livre sélectionné (s'il existe)
$selectedBookId = isset($_GET['id_book']) ? $_GET['id_book'] : null;

// Requête principale pour tous les livres
$sqlBooks = "SELECT book.id_book, book.title, book.publication_date, book.disponible,
                    author.first_name_author, author.name_author, 
                    type.name_type
             FROM `book` 
             INNER JOIN `author` ON book.id_author = author.id_author
             INNER JOIN `type` ON book.id_type = type.id_type";
$stmt = $pdo->prepare($sqlBooks);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librairie</title>
    <style>
        body {
            font-size: 1.5rem;
            padding: 150px;
            text-align: center;
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

        input,
        select {
            height: 40px;
            width: 30vw;
            cursor: pointer;
            border-radius: 12px;
            text-transform: uppercase;
            text-align: center;
        }

        #dispo {
            color: red;
        }

        .connect {
            border-radius: 12px;
            padding: 0.5rem 0.8rem;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <h1>Livres en location</h1>
    <form method="GET">
        <!-- 1. Choisir un livre -->
        <label for='bookSelect'>Choisir un livre par titre</label>
        <select name='id_book' id='bookSelect' onchange="this.form.submit()">
            <option value="">-- Sélectionnez un livre --</option>
            <?php foreach ($books as $book): ?>
                <?php
                $selected = ($book['id_book'] == $selectedBookId) ? 'selected' : '';
                $dispoText = ($book['disponible'] == 1) ? "" : "Indisponible";
                ?>
                <option value="<?= htmlspecialchars($book['id_book']) ?>" <?= $selected ?>>
                    <?= htmlspecialchars($book['title']) ?> :
                    <?= htmlspecialchars($book['first_name_author']) ?>
                    <?= htmlspecialchars($book['name_author']) ?> (
                    <?= htmlspecialchars($book['publication_date']) ?>)
                    <?= $dispoText ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- 2. Affichage disponibilité -->
        <label for='dispoBook'>Disponibilité</label>
        <select name='dispoBookTrue' id='dispoBook' disabled>
            <?php
            foreach ($books as $book) {
                if ($book['id_book'] == $selectedBookId) {
                    $dispoLabel = $book['disponible'] == 1 ? "Disponible" : "Indisponible";
                    echo "<option selected>$dispoLabel</option>";
                }
            }
            ?>
        </select>

        <!-- 3. Affichage du genre littéraire -->
        <label for='typeBook'>Genres littéraires</label>
        <select name="choiceType" id="typeBook" disabled>
            <?php
            foreach ($books as $book) {
                if ($book['id_book'] == $selectedBookId) {
                    echo "<option selected>" .
                        //htmlspecialchars($book['title']) . " : " .
                        htmlspecialchars($book['name_type']) .
                        "</option>";
                }
            }
            ?>
        </select>
    </form>
    <!-- nouveau formulaire pour la gestion de la librairie pour ajouter des livres -->
    <h2>Gestion des livres</h2>
    <form method="post">
        <label for="newTitle">Ajouter un nouveau livre</label>
        <input type="text" name="newTitle" required>
        <input type="submit" value="Ajouter à la bibliothèque">
    </form>
    <?php

    ?>




</body>

</html>