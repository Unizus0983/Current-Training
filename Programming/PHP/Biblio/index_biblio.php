<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'biblio';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Récupération de l'ID du livre sélectionné (s'il existe)
$selectedBookId = isset($_GET['id_book']) ? $_GET['id_book'] : null;

// Requête principale pour tous les livres
$sqlBooks = "SELECT book.id_book, book.title, book.publication_date, book.is_available,book.id_author,book.id_type,author.first_name, author.last_name, 
book_type.name_type
             FROM `book` 
             INNER JOIN `author` ON book.id_author = author.id_author
             INNER JOIN `book_type` ON book.id_type = book_type.id_type";
$stmt = $pdo->prepare($sqlBooks);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($books);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librairie</title>
    <style>
        * {
            text-decoration: none;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        a {
            color: inherit;
            border: 2px solid orange;
            padding: 0.5rem;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-content: center;
        }

        a:hover {
            background-color: orange;
        }

        body {
            font-size: 1.5rem;
            padding: 150px;
            text-align: center;
        }

        form {
            max-width: 50vw;
            margin: 0 auto;
            padding: 3rem;
            background-color: rgb(19, 238, 241);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        input,
        select,
        option {
            height: 40px;
            width: 35vw;
            cursor: pointer;
            border-radius: 12px;
            text-transform: uppercase;
            text-align: center;
            background-color: wheat;
            color: black;
        }



        .connect {
            border-radius: 12px;
            padding: 0.5rem 0.8rem;
            font-size: 1.2rem;
        }

        .green {
            color: green;
        }
    </style>
</head>

<body>
    <!-- /**********************FORMULAIRE 1 pour  LOCATION********************************* */ -->
    <h1>Livres en location</h1>
    <form>
        <!-- 1. Choisir un livre -->
        <label for="bookSelect">Choisir un livre par titre</label>
        <select name='id_book' id="bookSelect" onchange="this.form.submit()">
            <option value="">-- Sélectionnez un livre --</option>
            <?php foreach ($books as $book): ?>
                <?php
                $selected = ($book['id_book'] == $selectedBookId) ? 'selected' : '';
                $dispoText = ($book['is_available'] == 1) ? "" : "Indisponible";
                ?>
                <option value="<?= htmlspecialchars($book['id_book']) ?>" <?= $selected ?>>
                    <?= htmlspecialchars($book['title']) ?> :
                    <?= htmlspecialchars($book['first_name']) ?>
                    <?= htmlspecialchars($book['last_name']) ?> (
                    <?= htmlspecialchars($book['publication_date']) ?>)
                    <!-- <?= $dispoText ?> -->
                </option>
            <?php endforeach; ?>
        </select>

        <!-- 2. Affichage disponibilité -->
        <label for='dispoBook'>Disponibilité</label>
        <select name='dispoBookTrue' id='dispoBook' disabled>
            <?php
            foreach ($books as $book) {
                if ($book['id_book'] == $selectedBookId) {
                    $dispoLabel = $book['is_available'] == 1 ? "Disponible" : "Indisponible";
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
    <!-- *********************fin FORMULAIRE 1 *************************************  -->


    <!-- ******* 2 FORMULAIRES  pour ajouter un nouvelle auteur et un autre type littéraire******** -->
    <h2>Nouvelles données : auteurs et genres</h2>

    <!-- FORMULAIRE 2/1 NOUVELLES DONNEES  AUTEUR-->




    <form method="post">
        <label for="otherAuthor">Auteur (Prénom Nom)</label>
        <input type="text" name="otherAuthor" placeholder="Prénom Nom" required>

        <label for="birthDate">Date de naissance</label>
        <input type="date" name="birthDate" required>

        <input type="submit" name="submitAuthor" value="Enregistrer">
    </form>

    <?php
    if (isset($_POST['submitAuthor'])) {
        $fullName = trim($_POST['otherAuthor']);
        $birthDate = $_POST['birthDate'];

        // Découpe prénom et nom
        $parts = explode(' ', $fullName, 2);
        $firstName = ucfirst(strtolower($parts[0]));
        $lastName = isset($parts[1]) ? ucfirst(strtolower($parts[1])) : '';

        // Vérification minimale
        if (empty($lastName)) {
            echo "<p style='color:red'>⚠️ Veuillez saisir à la fois un prénom et un nom.</p>";
        } else {
            $sql = "INSERT INTO author (first_name, last_name, birth_date) 
                VALUES (:first, :last, :birthDate)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':first' => $firstName,
                ':last' => $lastName,
                ':birthDate' => $birthDate
            ]);

            echo "<p class='green'>Auteur enregistré : $firstName $lastName (Né le $birthDate)</p>";
            // réinitialisation de la page
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        }
    }
    ?>

    <!-- fin author -->

    <!-- FORMULAIRE 2/2 styles litteraires -->
    <hr>
    <form method="post">
        <label>Autre style littéraire</label>
        <input type="text" name='otherType' placeholder="Enregister un style littéraire" required>
        <input type="submit" name="submitType" value="Enregister">
    </form>
    <?php

    if (isset($_POST['submitType'])) {
        $otherType = trim($_POST['otherType']);

        // Requête d'insertion (sans id_type car auto-incrémenté)
        $sqlLiterary = "INSERT INTO `book_type`(`name_type`) VALUES (:otherType)";
        $stmtLiterary = $pdo->prepare($sqlLiterary);
        $stmtLiterary->execute([
            ':otherType' => $otherType
        ]);

        echo "<p class='green'>Style enregistré : " . htmlspecialchars($otherType) . "</p>";
        //réinitialisationde la page
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    }
    ?>
    <!-- fin styles litteraires -->

    <!-- *************fin formulaires auteurs et styles littéraires************ -->




    <!-- **** FORMULAIRE 3 (avec formulaires annexes) la gestion de la librairie pour ajouter des livres****** -->
    <h2>Gestion des livres</h2>
    <form method="post">
        <!--FORMULAIRE ANNEXE 1 DU FORMULAIRE 3  -->
        <!-- Ajouter un titre de livre à insérer librement -->
        <label for="newTitle">Ajouter un nouveau livre : titre </label>
        <input type="text" name="newTitle" required>

        <!-- liste des auteurs existants  -->
        <label for="newAuthor">Auteur du livre </label>
        <select name="newAuthor">
            <?php
            // Récupération des auteurs
            $sqlAuthors = "SELECT id_author,first_name, last_name FROM author";
            $stmtAuthors = $pdo->prepare($sqlAuthors);
            $stmtAuthors->execute();
            $authors = $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);
            ?>


            <?php
            foreach ($authors as $key => $author) {
                echo "<option value='" . htmlspecialchars($author['id_author']) . "'>" .
                    htmlspecialchars($author['first_name'] . ' ' . $author['last_name']) .
                    "</option>";
            }
            ?>


        </select>



        <!--Ajouter date de publication à insérer libre -->
        <label>Date de publication du livre</label>
        <input type="text" name="release" required>

        <!--genre littéraires existants -->
        <label>Genre littéraire de l'oeuvre </label>
        <select name="typeBook">
            <?php
            // Récupération des genres
            $sqlDifferentsTypes = "SELECT id_type, name_type FROM `book_type`";
            $sqlDifferentsTypes = $pdo->prepare($sqlDifferentsTypes);
            $sqlDifferentsTypes->execute();
            $differentTypes = $sqlDifferentsTypes->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php
            foreach ($differentTypes as $Key => $differentType) {
                echo "<option value='" . htmlspecialchars($differentType['id_type']) . "'>" . htmlspecialchars($differentType['name_type']) . " </option>";
            }
            ?>
        </select>

        <input type="submit" name="submitNew" value="Ajouter à la bibliothèque">
        <?php
        if (isset($_POST['submitNew'])) {
            $sqlNewbooks = "INSERT INTO `book`(`title`, `publication_date`, `id_author`, `id_type`) 
            VALUES (:newTitle, :release, :newAuthor, :typeBook)";
            $stmtNewbooks = $pdo->prepare($sqlNewbooks);
            $stmtNewbooks->execute([
                ':newTitle' => $_POST['newTitle'],
                ':release' => $_POST['release'],
                ':newAuthor' => $_POST['newAuthor'],
                ':typeBook' => $_POST['typeBook']
            ]);
            echo "<p class= 'green'>Le livre a bien étè enregistré !</p>";
            //reinitiialisation de la page
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        }


        ?>


    </form>
    <!--*************** Supprimer un livre******************-->
    <!-- 4/Créer un bouton de suppression pour chacune des entrées dans la BDD pour la table book RECUP id_book -->
    <!-- requete  PHP pour avoir toute les données LIVRES -->
    <?php
    //requête SQL POUR DONNEES LIVRES qui va servir pour tout ce qui touche à la modification ou suppression d'un livre
    $sqlAll = "SELECT * FROM `book`";
    //préparation + éxecution de la requête
    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();
    $resultsAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($resultsAll);
    ?>
    <!-- FORMULAIRE  annexe 2 (DS GESTION DES LIVRES) pour envoyer l'information du livre à supprimer -->

    <form method="post" ">
            <label for=" id_book">Sélectionnez un livre à supprimer :</label>

        <select name="id_book" required>
            <option value="">-- Choisir un livre --</option>
            <?php foreach ($resultsAll as $row): ?>
                // id_book provient de la BDD
                <option value="<?= htmlspecialchars($row['id_book']) ?>">
                    <?= htmlspecialchars($row['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="submitDelete" value="Supprimer" style="background-color: red; color: white;">
    </form>
    <?php
    if (isset($_POST['submitDelete']) && !empty($_POST['id_book'])) {
        $sqlDelete = "DELETE FROM `book` WHERE `id_book` = :idDelete";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([':idDelete' => $_POST['id_book']]);

        echo "<p class='green'>Le livre a bien été supprimé.</p>";
        echo "<script>location.reload();</script>";
        header("Location: index.php?updated=1");
        exit;
    }
    ?>
    <hr>
    <!--  FORMULAIRE  annexe3 (dans gestion livres)modification d'un titre de livre METHODE UPDATE -->
    <form method="post">
        <label for="id_book">Choisir un livre à modifier :</label>
        <select name="id_book" required>
            <option value="">-- Sélectionnez un livre --</option>
            <?php foreach ($resultsAll as $row): ?>
                <option value="<?= htmlspecialchars($row['id_book']) ?>">
                    <?= htmlspecialchars($row['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="newTitle">Nouveau titre :</label>
        <input type="text" name="newTitle" required placeholder="Entrez le nouveau titre">

        <input type="submit" name="submitUpdate" value="Modifier le titre" style="background-color: orange; color: white;">
    </form>
    <?php
    // :newtitle et :id sont des noms de variable = paramètre placeholder voir note sur notion
    // =>  auquels on peut donner le nom que l'on veut 
    if (isset($_POST['submitUpdate']) && !empty($_POST['id_book']) && !empty($_POST['newTitle'])) {
        $sqlUpdate = "UPDATE `book` SET `title` = :newTitle WHERE `id_book` = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':newTitle' => $_POST['newTitle'],
            ':id' => $_POST['id_book']
        ]);

        echo "<p class='green'>Le titre a bien été modifié.</p>";
        //réinitialisation de la page
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    }
    ?>
    <!-- ************fin GESTION DES LIVRES COMPRENANTS 3 FORMULAIRE ANNEXES -->
    <!-- gestion des emprunts et des restitution -->


    <h2>Emprunts livres</h2>
    <form method="POST">
        <?php
        // Requête SQL : tous les usagers triés par nom
        $sqlUser = "SELECT * FROM user ORDER BY last_name ASC";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute();
        $resultsUser = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php
        // condition execution formulaire emprunts annexe 1
        if (isset($_POST['submitLoan'])) {
            $idBook = $_POST['id_book'];
            $idUser = $_POST['id_user'];
            $loanDate = $_POST['loan_date'];

            // Insertion dans la table loan
            $sqlLoan = "INSERT INTO loan (loan_date, id_user, id_book, returned)
                VALUES (:loanDate, :idUser, :idBook, FALSE)";
            $stmt = $pdo->prepare($sqlLoan);
            $stmt->execute([
                ':loanDate' => $loanDate,
                ':idUser' => $idUser,
                ':idBook' => $idBook
            ]);
            $loanId = $pdo->lastInsertId(); // récupère l'ID de l'emprunt qu'on vient d'ajouter

            $sqlHistoryInsert = "INSERT INTO history (id_loan, event_type) VALUES (:idLoan, 'created')";
            $stmtHist = $pdo->prepare($sqlHistoryInsert);
            $stmtHist->execute([':idLoan' => $loanId]);



            // Mettre à jour la disponibilité du livre
            $sqlUpdate = "UPDATE book SET is_available = 0 WHERE id_book = :idBook";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([':idBook' => $idBook]);

            echo "<p class='green'>✅ Emprunt enregistré avec succès.</p>";
            //réinitialisation de la page
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        }

        ?>
        <hr>
        <!-- FORMULAIRE emprunts et restitution avec 2 annnexes -->

        <!-- formulaires annexe1 pour emprunts des livres -->

        <select name="id_user">
            <option value="">-- Sélectionnez un usager --</option>
            <?php foreach ($resultsUser as $user): ?>
                <option value="<?= htmlspecialchars($user['id_user']) ?>">
                    <?= htmlspecialchars($user['last_name']) . " " . htmlspecialchars($user['first_name']) ?> -
                    <?= htmlspecialchars($user['email']) ?> -
                    inscrit le <?= htmlspecialchars($user['registration_date']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- choix du livre -->
        <label for="id_book">Choisir un livre</label>
        <select name="id_book" required>
            <option value="">-- Sélectionnez un livre --</option>
            <?php foreach ($books as $book): ?>
                <?php if ($book['is_available'] == 1): // uniquement les livres disponibles 
                ?>
                    <option value="<?= htmlspecialchars($book['id_book']) ?>">
                        <?= htmlspecialchars($book['title']) ?> -
                        <?= htmlspecialchars($book['first_name']) . " " . htmlspecialchars($book['last_name']) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <!-- Date d’emprunt -->
        <label for="loan_date">Date de prêt</label>
        <!-- voir lien notion notes pour date du jour fonction php date() -->
        <input type="date" name="loan_date" value="<?= date('Y-m-d') ?>" required>

        <input type="submit" name="submitLoan" value="Enregistrer l’emprunt" style="background-color: orange; color: white;">
    </form>
    <hr>
    <!--************ fin de l'annexe 1 gestion emprunts********** -->

    <!-- FORMULAIRE annexe 2 pour restituion de la gestion des emprunts -->
    <?php
    //requete pour reunir les données de locations de livres et adhérents
    $sqlReturns =
        "SELECT loan.id_loan, book.title, user.first_name, user.last_name, loan.id_book, loan.id_user
    FROM `loan`
    INNER JOIN `book` ON loan.id_book = book.id_book
    INNER JOIN `user` ON loan.id_user = user.id_user
    WHERE book.is_available = 0 AND loan.returned = 0";
    $stmtReturns = $pdo->prepare($sqlReturns);
    $stmtReturns->execute();
    $loansToReturn = $stmtReturns->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <?php
    //EXECUTION POUR restitution
    if (isset($_POST['submitReturn'])) {
        $loanId = $_POST['loan_id'];
        $returnDate = $_POST['restitutedate'];

        // 1. Mettre à jour la table loan (livre rendu)
        $sqlUpdateLoan = "UPDATE loan SET returned = 1, return_date = :ret WHERE id_loan = :loanId";
        $stmt = $pdo->prepare($sqlUpdateLoan);
        $stmt->execute([
            ':ret' => $returnDate,
            ':loanId' => $loanId
        ]);
        //pour la tableau des historiques
        $sqlHistoryInsert = "INSERT INTO history (id_loan, event_type) VALUES (:idLoan, 'returned')";
        $stmtHist = $pdo->prepare($sqlHistoryInsert);
        $stmtHist->execute([':idLoan' => $loanId]);


        // 2. Mettre à jour la disponibilité du livre
        $sqlGetBookId = "SELECT id_book FROM loan WHERE id_loan = :loanId";
        $stmt = $pdo->prepare($sqlGetBookId);
        $stmt->execute([':loanId' => $loanId]);
        $bookId = $stmt->fetchColumn();

        $sqlUpdateBook = "UPDATE book SET is_available = 1 WHERE id_book = :bookId";
        $stmt = $pdo->prepare($sqlUpdateBook);
        $stmt->execute([':bookId' => $bookId]);

        echo "<p class='green'>✅ Livre restitué avec succès.</p>";

        // Redirection pour rafraîchir la liste
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    }
    ?>


    <h3>Restitution de livres</h3>
    <form method="post">
        <label for="loanSelect">Sélectionner un emprunt à restituer</label>
        <select name="loan_id" required>
            <option value="">-- Sélectionner un emprunt --</option>
            <?php foreach ($loansToReturn as $loan): ?>
                <option value="<?= htmlspecialchars($loan['id_loan']) ?>">
                    <?= htmlspecialchars($loan['title']) ?> <span>emprunté par</span>
                    <?= htmlspecialchars($loan['first_name']) ?> <?= htmlspecialchars($loan['last_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="restitutedate">Date de restitution</label>
        <input type="date" name="restitutedate" value="<?= date('Y-m-d') ?>" required>

        <input type="submit" name="submitReturn" value="Restituer">
    </form>





    <!-- FORMULAIRES POUR AJOUTER UN NOUVEL ADHERENT -->
    <h2>Nouvel adhérent</h2>
    <?php
    if (isset($_POST['submitUser'])) {
        // Le formulaire a été soumis, on vérifie les champs
        if (
            !empty($_POST['lastName_user']) &&
            !empty($_POST['firstName_user']) &&
            !empty($_POST['userMail']) &&
            !empty($_POST['registrationDate'])
        ) {
            $firstName = trim($_POST['firstName_user']);
            $lastName = trim($_POST['lastName_user']);
            $userMail = trim($_POST['userMail']);
            $registrationDate = $_POST['registrationDate'];

            // Insertion nouvelle requete user
            $sqlInsertUser = "INSERT INTO `user` (`last_name`, `first_name`, `email`, `registration_date`, `is_active`)
                          VALUES (:lastUser, :firstUser, :mailUser, :dateday, 1)";
            $stmt = $pdo->prepare($sqlInsertUser);
            $stmt->execute([
                ':lastUser' => $lastName,
                ':firstUser' => $firstName,
                ':mailUser' => $userMail,
                ':dateday' => $registrationDate
            ]);
            echo "<p class='green'>✅ Adhérent enregistré avec succès.</p>";
            //réinitialisation de la page
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        } else {
            // ❌ Affiche l’erreur seulement si formulaire soumis et incomplet
            echo "<p style='color:red'>❌ Veuillez remplir tous les champs pour enregistrer l’adhérent.</p>";
        }
    }
    ?>

    <!-- FORMULAIRE INSCRIPTION -->

    <form method="post">
        <label for="lastName_user">Nom</label>
        <input type="text" name="lastName_user" required>
        <label for="firstName_user">Prènom</label>
        <input type="text" name="firstName_user" required>
        <label for="userMail">Adresse mail </label>
        <input type="email" name="userMail" style="text-transform: none;" placeholder="contact@gmail.com" required>
        <label for="registrationDate">Date d'inscription</label>
        <input type="date" name="registrationDate" value="<?= date('Y-m-d') ?>" required>
        <input type="submit" name="submitUser" value="Enregistrer le nouvel adhérent">
    </form>

    <!-- FORMULAIRE SUPPRESSION ADHERENT -->
    <?php
    // ✅ Objectif de cette requête
    //👉 Trouver tous les utilisateurs (adhérents) qui n'ont aucun livre emprunté actuellement.
    $sqlDeletableUsers = "SELECT user.id_user, user.first_name, user.last_name FROM `user` WHERE user.id_user NOT IN ( SELECT loan.id_user FROM loan WHERE loan.returned = 0 ) ORDER BY last_name ASC";


    $stmtDelUsers = $pdo->prepare($sqlDeletableUsers);
    $stmtDelUsers->execute();
    $usersToDelete = $stmtDelUsers->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($usersToDelete);
    ?>
    <h2>Supprimer un adhérent</h2>
    <form method="post">
        <label for="id_user">Adhérents sans emprunt actif</label>
        <select name="id_user" required>
            <option value="">-- Sélectionner un adhérent à supprimer --</option>
            <?php foreach ($usersToDelete as $user): ?>
                <option value="<?= htmlspecialchars($user['id_user']) ?>">
                    <?= htmlspecialchars($user['last_name']) ?> <?= htmlspecialchars($user['first_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="submitDeleteUser" value="Supprimer l’adhérent" style="background-color: red; color: white;">
    </form>

    <?php
    if (isset($_POST['submitDeleteUser']) && !empty($_POST['id_user'])) {
        $idUser = $_POST['id_user'];

        // Re-vérifie qu'il n'a aucun emprunt actif
        $sqlCheck = "SELECT COUNT(*) FROM loan WHERE id_user = :idUser AND returned = 0";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':idUser' => $idUser]);
        $hasActiveLoans = $stmtCheck->fetchColumn();

        if ($hasActiveLoans > 0) {
            echo "<p style='color:red'>❌ Cet adhérent ne peut pas être supprimé car il a encore des livres empruntés.</p>";
        } else {
            $sqlDelete = "DELETE FROM user WHERE id_user = :idUser";
            $stmtDel = $pdo->prepare($sqlDelete);
            $stmtDel->execute([':idUser' => $idUser]);
            echo "<p class='green'>✅ Adhérent supprimé avec succès.</p>";
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit;
        }
    }
    ?>



    <?php
    // VERSION CORRIGÉE DE LA RÉCUPÉRATION DE L'HISTORIQUE
    try {
        // 1. Vérifiez d'abord que la table existe
        $tableExists = $pdo->query("SHOW TABLES LIKE 'history'")->rowCount() > 0;

        if (!$tableExists) {
            throw new Exception("La table 'history' n'existe pas");
        }

        // 2. Requête avec gestion d'erreur améliorée
        $sqlHistory = "SELECT 
                    h.id_history,
                    h.event_type,
                    DATE_FORMAT(h.event_date, '%d/%m/%Y %H:%i') AS formatted_date,
                    u.first_name,
                    u.last_name,
                    b.title
                  FROM history h
                  JOIN loan l ON h.id_loan = l.id_loan
                  JOIN user u ON l.id_user = u.id_user
                  JOIN book b ON l.id_book = b.id_book
                  ORDER BY h.event_date DESC
                  LIMIT 100"; // Limitez pour les tests

        $stmt = $pdo->prepare($sqlHistory);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête");
        }

        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "<div style='color:red;padding:10px;border:1px solid red;'>";
        echo "<strong>Erreur historique :</strong> " . $e->getMessage();
        echo "<p>Requête essayée :<br><code>" . htmlspecialchars($sqlHistory) . "</code></p>";
        echo "</div>";
        $history = [];
    }
    ?>

    <!-- AFFICHAGE -->
    <h2>Historique des emprunts</h2>

    <?php if (empty($history)): ?>
        <p>Aucun enregistrement dans l'historique.</p>
        <?php if ($tableExists ?? false): ?>
            <p><small>Astuce : Vérifiez que des données existent dans la table 'history'</small></p>
        <?php endif; ?>
    <?php else: ?>
        <table border="1" style="width:100%;border-collapse:collapse;margin-top:20px;">
            <thead style="background-color:#f2f2f2;">
                <tr>
                    <th>Utilisateur</th>
                    <th>Livre</th>
                    <th>Événement</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td>
                            <?= match ($row['event_type']) {
                                'created' => '📗 Emprunt',
                                'returned' => '📕 Retour',
                                'overdue' => '⚠️ Retard',
                                default => htmlspecialchars($row['event_type'])
                            } ?>
                        </td>
                        <td><?= $row['formatted_date'] ?? htmlspecialchars($row['event_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>




















</body>

</html>