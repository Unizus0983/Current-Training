<?php

//## Crée une classe Chien qui a deux propriétés :

// nom
// race

// ## Ajoute à cette classe :


// Une méthode aboyer() qui affiche "Woof! Je suis [nom]".

// Ensuite :

// - Crée un objet $chien1 de la classe Chien avec le nom "Rex" et la race "Berger Allemand".
// - Affiche le nom et la race du chien.
// - Change le nom du chien en "Max".
// - Fais aboyer le chien avec la méthode aboyer().
class Chien
{
    public $nom;
    public $race;
    //constructeur

    public function __construct($param1, $param2)
    {
        $this->nom = $param1;
        $this->race = $param2;
    }

    // Getters
    public function getNom()
    {
        return $this->nom;
    }

    public function getRace()
    {
        return $this->race;
    }

    // Setters
    public function setNom($nouveauNom)
    {
        $this->nom = $nouveauNom;
    }

    public function setRace($nouvelleRace)
    {
        $this->race = $nouvelleRace;
    }

    // Méthode aboyer
    public function aboyer()
    {
        echo "Woof! Je suis " . $this->nom . ".";
    }
}

// Créer une chasse Humain
// Créer 2 enfants de Humain : Homme et Femme

// Tester les fonctionnalités d'héritage entre parent et enfant en utilisant les méthodes du parents via l'enfant
// php
// class Chat extends Animal {

//     public function __construct($couleur) {
//         $this->pattes = "4";
//         $this->couleur = $couleur;
//     }

// }
