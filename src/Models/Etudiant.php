<?php
declare(strict_types=1);
namespace App\Models;

class Etudiant
{
    private static int $compteur = 1;

    // Constructeur moderne PHP 8 - propre IAI
    public function __construct(
        private string $nom,
        private string $prenom,
        private int $age,
        private float $moyenne,
        private string $filier,
        private string $matricul = ''
    ) {
        // Génération auto du matricule IAI0001, IAI0002...
        if ($matricul === '' || $matricul === null) {
            $this->matricul = 'IAI' . str_pad((string) self::$compteur, 4, '0', STR_PAD_LEFT);
            self::$compteur++;
        } else {
            $this->matricul = $matricul;
        }
    }

    // ===== GETTERS =====
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getAge(): int { return $this->age; }
    public function getMoyenne(): float { return $this->moyenne; }
    public function getFilier(): string { return $this->filier; }
    public function getMatricul(): string { return $this->matricul; }
    
    // Alias pour compatibilité avec ton ancien code getmatricul()
   // public function getmatricul(): string { return $this->matricul; }

    // ===== SETTERS avec validation =====
    public function setNom(string $newNom): void {
        if (trim($newNom) !== "") {
            $this->nom = $newNom;
        }
    }

    public function setPrenom(string $newPrenom): void {
        $this->prenom = $newPrenom;
    }

    public function setAge(int $newAge): void {
        $this->age = $newAge;
    }

    // CORRECTION DU BUG que tu avais
    public function setMoyenne(float $newMoyenne): void {
        if ($newMoyenne < 0 || $newMoyenne > 20) {
            throw new \InvalidArgumentException("Moyenne doit être entre 0 et 20");
        }
        $this->moyenne = $newMoyenne;
    }

    public function setFilier(string $newFilier): void {
        $this->filier = $newFilier;
    }

    public function setMatricul(string $newMatricul): void {
        $this->matricul = $newMatricul;
    }

    // ===== REGLES METIER PROFESSEUR =====
    // Règle 1 : Admis ou non ?
    public function isAdmis(): bool {
        return $this->moyenne >= 10;
    }

    // Règle 2 : Mention académique
    public function getMention(): string {
        return match (true) {
            $this->moyenne < 10 => "Échoué",
            $this->moyenne < 12 => "Passable",
            $this->moyenne < 14 => "Assez Bien",
            $this->moyenne < 16 => "Bien",
            $this->moyenne < 18 => "Très Bien",
            $this->moyenne <= 20 => "Excellent",
            default => "Invalide"
        };
    }

    // Règle 3 : Appréciation courte pour le tableau
    public function getStatut(): string {
        return $this->isAdmis() ? "Admis" : "Échoué";
    }
}
