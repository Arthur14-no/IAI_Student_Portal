<?php
declare(strict_types=1); //permet de rendre strict le lutilisation des variables.;

namespace App\Models; //ici il remplace 'require' ou 'include' grace au compser.

// cretion de la classe etudiant
class Etudiant{
    private static int $compteur= 1; //pour toute la classse.
  

    // cretaions des du contructeurs pour linitialisation des objects
    public function __construct(
        private string $nom,
        private string $prenom,
        private int $age,
        private float $moyenne,
        private string $filier,
        private string $matricul= ''
    ){
       
       /* $this->matricul= 'IAI' .rand(0001,9999);*/


       if ($matricul === '' || $matricul === null) {
        $this-> matricul= 'IAI'. str_pad((string) self::$compteur, 4,'0', STR_PAD_LEFT);
        self::$compteur++;

       }else {
        $this-> matricul= $matricul;
       }
       

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


    // permet la modification des propieter de la classe etudiants
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

            throw new \InvalidArgumentException("entre 0 et 20");
            
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
            $this-> moyenne <10 => "Vous avez echoué !",
            $this-> moyenne <12 => "vous avez reussis, assez bien",
            $this-> moyenne <14 => "vous avez reussis, bien",
            $this-> moyenne <16 => "vous avez reussis, tres bien",
            $this-> moyenne <18 => "vous avez reussis, exellent !",
            $this-> moyenne <=20 => "vous avez reussis, exellent",
        };
    }

   /* public function compterTous(): int{
        $stmt = $this-> db-> query("SELECT COUNT(*) as total FROM etudiants");

        return(int) $stmt-> fetch()['total'];
    }

    public function getPagine(int $limit, int $offset): array{
        $stmt= $this-> db-> prepare("SELECT * FROM etudiants ORDER BY moyenne DESC LIMIT :limit OFFSET :offset");
        $stmt-> bindvalue(':limit', $limit, \PDO::PARAM_INT);
        $stmt-> bindvalue(':offset', $offset, \PDO::PARAM_INT);
        $stmt-> execute();

        return $stmt-> fetchALL();
    }*/
}

?>