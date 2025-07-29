<?php

class Compte
{
    private $titulaire;
    private $solde;

    public function __construct(string $nomTitulaire, float $montant)
    {
        $this->titulaire = $nomTitulaire;
        $this->solde = $montant;
    }

    //*****************ACCESSEURS********************
    //GETTER
    /**getter de titulaire : retourne la valeur du titulaire du compte */
    public function getTitulaire(): string
    {
        return $this->titulaire;
    }
    public function getSolde(): float
    {
        return $this->solde;
    }

    //SETTER
    /**modifie le nom du titulaire et retourne l'objet */
    public function setTitulaire(string $nomTitulaire): self
    {   //on verifie si on a un titulaire 
        if ($nomTitulaire != "") {
            # code...
            $this->titulaire = $nomTitulaire;
        }
        return $this;
    }
    /**modifie le solde et retourne le montant du solde du compte */
    public function setSolde(float $montant): self
    {   //on verifie si on a un titulaire 
        if ($montant >= 0) {
            # code...
            $this->titulaire = $montant;
        }
        return $this;
    }


    //*************METHODES pour les actions************** */

    public function deposer(float $montant): void
    {
        if ($montant > 0) {
            $this->solde += $montant;
        }
    }

    public function voirSolde(): string
    {
        return "Le solde du compte est de : $this->solde €uros";
    }

    public function retirer(float $montant): string
    {
        if ($montant > 0 && $this->solde >= $montant) {
            $this->solde -= $montant;
            return "Retrait de $montant € effectué.";
        } else {
            return "Votre solde de compte est insuffisant.";
        }
    }
}
