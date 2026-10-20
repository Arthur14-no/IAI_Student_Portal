<?php
declare(strict_types=1); //permet de rendre strict le lutilisation des variables.;

namespace App\Models; //ici il remplace 'require' ou 'include' grace au compser.


class Etudiant{
    private static int $compteur= 1; //pour toute la classse.
    private string $nom;
    private string $prenom;
    private int $age;
    private string $matricul;
    private float $moyenne;
    private string $filier;

    // cretaions des du contructeurs pour linitialisation des objects
    public function __construct(string $nom, string $prenom, int $age, float $moyenne, string $filier){
        $this->nom = $nom;
        $this->prenom =$prenom;
        $this->age = $age;
       // $this->matricul= 'IAI' .rand(0001,9999);
        $this->matricul= 'IAI' .str_pad((string)self::$compteur, 4, '0', STR_PAD_LEFT); self::$compteur++;
        $this->moyenne= $moyenne;
        $this->filier= $filier;

       // echo "Etudiant cree ! <br/>";
    }

    //toujours affecter les variables par leurs noms
    public function Presenter(){
        echo 'Bonjour ' .$this->nom. ' ' .$this->prenom. ' , matricule : ' .$this->matricul. ', filiere : ' .$this->filier. ', moyenne : ' .$this->moyenne. '<br/>'; 
        }
    
    
    //permet les lecture des nouvelles valleurs qui seront setters 
    public function getNom() : string {
        return $this->nom;
    }
    public function getPrenom(): string{
        return $this->prenom;
    }
    public function getAge(): int {
        return $this->age;
    }
    public function getmatricul(): string{
        return $this->matricul;
    }
    public function getMoyenne(): float{
        return $this->moyenne; 
    }
    public function getFilier(): string{
        return $this->filier;
    }



    public function setNom($newNom): void {
        if (trim($nom) !== ""){
             $this->nom= $newNom;
        }
    }
      public function setPrenom($newPrenom): void{
        $this->prenom= $newPrenom;
    }
     public function setAge($newAge): void{
        $this->age= $newAge;
    }
     public function setMatricul($newMatricul): void{
        $this->matricul= $newMatricul;
    }

    /* public function setMoyenne($newMoyenne): void{
        $this->prenom= $newMoyenne;
    }*/
    
    public function setMoyenne($newMoyenne){
        if ($newMoyenne >=0 && $newMoyenne <=20) {
            $this->moyenne= $newMoyenne; 
        }
    }
     public function setFilier($newFilier): void{
        $this->filier= $newFilier;
    }
    

    // permet de donner la preciations en fonction de la moyenne.
    public function Moyenne(){
       /* if ($this->moyenne >= 10) {
            return " Vous avez reussit ! <br/>";
        }
        else {
            return " Vous avez echouer ! <br/>";
        }*/
        return match (true) {
            $this-> moyenne <10 => "Vous avvez echoué !",
            $this-> moyenne <12 => "vous avez reussis, assez bien",
            $this-> moyenne <14 => "vous avez reussis, bien",
            $this-> moyenne <16 => "vous avez reussis, tres bien",
            $this-> moyenne <18 => "vous avez reussis, exellent !",
            $this-> moyenne <=20 => "vous avez reussis, exellent",
        };
    }
}

?>