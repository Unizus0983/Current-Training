<?php
$host = 'localhost';
$dbname = 'vehicule';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Active les erreurs PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie !";
    $sql = "SELECT * FROM `vl`";

    // Préparation + Execution de la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($results);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Formulaires Véhicule</title>
</head>

<body>

    <!-- 2/Créer un formulaire pour les tables couleur et type véhicule afin d'envoyer en BDD les couleurs notés dans votre formulaire -->
    <!-- formulaire 1 couleur du véhicule -->
    <form method="post">
        <label>Couleur du véhicule :</label>
        <input type="text" name="couleur" required>
        <input type="submit" name="color_vehicle" value="Ajouter la couleur du véhicule">
    </form>
    <br>
    <?php
    if (isset($_POST['couleur']) && isset($_POST['color_vehicle'])) {
        $sql = "INSERT INTO `color`(`name_color`) VALUES (:couleur)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':couleur' => $_POST['couleur']]);
    }
    ?>



    <!-- formulaire 2 type de vl -->
    <form method="post">
        <label>Type du véhicule :</label>
        <input type="text" name="type" required>
        <input type="submit" name="type_vehicle" value="Ajouter type du véhicule">
    </form>
    <br>
    <?php
    if (isset($_POST['type']) && isset($_POST['type_vehicle'])) {
        $sql = "INSERT INTO `type vl`(`name_type`) VALUES (:type)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':type' => $_POST['type']]);
    }
    ?>
    <hr>
    <!-- 3/Créer la suite du formulaire pour ajouter un véhicule avec les clés étrangères -->
    <!-- requete pour le formulaire 3 -->
    <?php
    //pour avoir les informations avec les id étrangers
    $sqlColor = "SELECT * FROM `color`";
    $stmtColor = $pdo->prepare($sqlColor);
    $stmtColor->execute();
    $resultsColor = $stmtColor->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($resultsColor);
    // echo "<br>";
    // echo "<br>";
    $sqlType = "SELECT * FROM `type_vl`";
    $stmtType = $pdo->prepare($sqlType);
    $stmtType->execute();
    $resultsType = $stmtType->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <br>
    <br>

    <!-- formulaire 3 -->
    <form method="post">
        <!-- immatriculation du VL -->
        <label>Ajouter une immatriculation véhicule</label>
        <input type="text" name="immatVL" required>
        <!-- couleur du VL -->
        <label>Couleur du véhicule</label>
        <select name="id_typeColor">
            <?php
            foreach ($resultsColor as $key => $value) {
                echo "<option value='" . htmlspecialchars($value['Id_color']) . "'>" . htmlspecialchars($value['name_color']) . "</option>";
            }
            ?>
        </select>
        <!-- type de vehicule -->
        <label>Type de véhicule</label>
        <select name="id_typeVL">
            <?php
            foreach ($resultsType as $key => $value) {
                echo "<option value='" . htmlspecialchars($value['Id_typeVL']) . "'>" . htmlspecialchars($value['name_type']) . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="add_vehicule" value="Ajouter le véhicule">

        <?php
        if (
            isset($_POST['immatVL']) &&
            isset($_POST['id_typeColor']) &&
            isset($_POST['id_typeVL']) &&
            isset($_POST['add_vehicule'])
        ) {


            $sql = "INSERT INTO `vl`(`immatriculation`, `Id_typeVL`, `Id_color`) VALUES (:immatVL, :id_typeVL, :id_typeColor)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':immatVL' => $_POST['immatVL'],
                ':id_typeVL' => $_POST['id_typeVL'],
                ':id_typeColor' => $_POST['id_typeColor']
            ]);
        }
        ?>

    </form>
    <br>
    <br>
    <hr>

    <!-- 4/Créer un bouton de suppression pour chacune des entrées dans la BDD pour la table vl -->
    <!-- requete  PHP pour avoir toute les données  -->
    <?php
    //requête SQL
    $sqlAll = "SELECT * FROM `vl`";
    //préparation + éxecution de la requête
    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();
    $resultsAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($resultsAll);
    ?>
    <!-- formulaire pour envoyer l'information -->


    <?php
    foreach ($resultsAll as $key => $value) {
        echo '<form method="post">'; //formulaire
        foreach ($value as $key => $value2) {
            echo $key  . " :   " . $value2 . "  /--  ";
        }
        //recuperation de la valeur de l'ID_Vl de la table 
        echo '<input type="hidden" name="idDelete" value="' . htmlspecialchars($value['Id_VL']) . '">';
        echo '<input type="submit" name="submitDelete" value="Supprimer">';
        echo "&nbsp;";
        echo "&#160;";
        echo '<a href="?id='  . htmlspecialchars($value['Id_VL']) . '">Modifier</a>';
        echo '</form>'; //fin formulaire
        echo '<br>';
        echo '<br>';
    }
    if (isset($_POST['submitDelete']) && isset($_POST['idDelete'])) {
        $sqlDelete = "DELETE FROM `vl` WHERE `Id_VL` = :idDelete";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([':idDelete' => $_POST['idDelete']]);
    }






    ?>
    <hr>
    // 5/ Créer le formulaire Update
    // 5/formulaire pour mise à jour dans la basse de données
    <?php
    //echo $_GET['id'];
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sqlID = "SELECT * FROM `vl` WHERE Id_VL = '$id'";
        //préparation + éxecution de la requête
        $stmtID = $pdo->prepare($sqlID);
        $stmtID->execute();
        $resultsID = $stmtID->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($resultsID)) {
            $edit = $resultsID[0];
            echo '<form method="post">';
            echo '<input type="text" name="idUpdate" value="' . htmlspecialchars($edit['Id_VL']) . '" placeholder="identifiant du véhicule">';
            echo '<input type="text" name="immatUpdate" value="' . htmlspecialchars($edit['immatriculation']) . '" placeholder="immatriculation véhicule">';
            echo '<input type="text" name="colorUpdate" value="' . htmlspecialchars($edit['Id_color']) . '" placeholder="couleur véhicule">';
            echo '<input type="text" name="typeVldUpdate" value="' . htmlspecialchars($edit['Id_typeVL']) . '" placeholder="type de véhicule">';
            echo '<input type="submit" name="submitUpdate" value="Validez">';
            echo '</form>';
        }
        var_dump($resultsID);
    }
    if (isset($_POST['submitUpdate'])) {
        $sqlUpdate = "UPDATE `vl` SET `immatriculation`= :immatUpdate,`Id_typeVL`= :typeVldUpdate,`Id_color`= :colorUpdate WHERE `Id_VL` = :idUpdate ";
        //préparation + éxecution de la requête
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':immatUpdate' => $_POST['immatUpdate'],
            ':typeVldUpdate' => $_POST['typeVldUpdate'],
            ':colorUpdate' => $_POST['colorUpdate'],
            ':idUpdate' => $_POST['idUpdate']
        ]);
    }
    ?>










</body>

</html>