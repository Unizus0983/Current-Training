<?php
class User
{
    private $id_visiteur;
    private $name;
    private static $pdo; // Connexion pour toute la classe

    // CONSTRUCTEUR
    public function __construct($id_visiteur = null, $name = null)
    {
        $this->id_visiteur = $id_visiteur;
        $this->name = $name ?? "Invité";
    }

    // MÉTHODE POUR DÉFINIR LA CONNEXION
    public static function setConnection($pdo)
    {
        self::$pdo = $pdo;
    }

    // GETTERS
    public function getIdVisiteur()
    {
        return $this->id_visiteur;
    }

    public function getName()
    {
        return $this->name;
    }

    // SETTERS
    public function setIdVisiteur($id_visiteur)
    {
        $this->id_visiteur = $id_visiteur;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    // MÉTHODE POUR RÉCUPÉRER UN USER
    public static function getFromDatabase($id_visiteur = 1)
    {
        $sql = "SELECT * FROM person WHERE id_visiteur = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$id_visiteur]);
        $data = $stmt->fetch();
        // debug
        // AJOUTE CE DEBUG :
        echo "<div style='background: yellow; padding: 10px; margin: 10px 0;'>";
        echo "<strong>DEBUG :</strong><br>";
        echo "Requête : $sql<br>";
        echo "ID cherché : $id_visiteur<br>";
        echo "Résultat : ";
        var_dump($data);
        echo "</div>";

        if ($data) {
            return new User($data['id_visiteur'], $data['name']);
        }
        return new User(); // "Invité" si pas trouvé
    }
}
