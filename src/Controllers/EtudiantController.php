<?php
     declare(strict_types=1);

                //ici on renseigne ladresse du fichier grace au composer.
                namespace App\controllers;


                //ici on precise quil utilise la classe etudiant.
                use App\Models\Etudiant;

                // a defaut de creer des objet a part et de les rensigner dans lindex on creer une fois une classe index qui va eter appler dans index.php.
                class Etudiantcontroller{


                private $db;

                public function __construct(){
                    
                    require __DIR__. '/../config/Database.php';
                    $database= new \Database();
                    $this-> db =$database->getConnexion();
                }


                private function getEtudiants(): array{
                    $query= "SELECT * FROM etudiants";

                    $stmt= $this-> db->prepare($query);
                    $stmt->execute();

                    $etudiants= [];
                    while ($row = $stmt->fetch()) {
                        $etudiants[]= new \App\Models\Etudiant(
                        $row['nom'],
                        $row['prenom'],
                        (int)$row['age'],
                        (float)$row['moyenne'] ?? 20,
                        $row['filiere'] ?? $row['mention']
                        );
                    }
                    
                    return $etudiants;
                }
                        
                
                    public function Listes(): void{
                        $etudiants= $this->getEtudiants();
                        $stats= $this-> getStat();

                        usort($etudiants, function($e, $b){
                            return strcmp(strtolower($e-> getNom()), strtolower($b-> getNom()));
                        });


                        if (isset($_GET['tri']) && !empty($_GET['tri']) && $_GET['tri']) {
                            usort($etudiants, function($e, $b){

                                if ($e-> getMoyenne() == $b-> getMoyenne()) {
                                    return 0;
                                }

                                return ($e-> getMoyenne() < $b-> getMoyenne()) ? 1 : -1;
                            });
                        }
                            

                        if (isset($_GET['q']) && !empty($_GET['q'])) {
                            $motCle= strtolower($_GET['q']);
                            $filtre= array();

                            foreach ($etudiants as $unEtudiant) {
                                $nomComplet= strtolower($unEtudiant-> getNom(). ' ' .$unEtudiant->  getPrenom());

                                if (strpos($nomComplet, $motCle) !== false  ) {
                                    $filtre[]= $unEtudiant;
                                }
                            }

                            $etudiants= $filtre;
                        }


                        require __DIR__ . '/../../views/Listes.php';
                    }



                    //cette fontion va permettre de filter les etudiant ayant eu >=10 ou <10.
                    public function Admis(): void{
                        $etudiants= $this->getEtudiants();
                         $admis= array_filter($etudiants, function($e){
                        return $e->getMoyenne() >=10;    
                });

                    require __DIR__. '/../../views/ListesAdmis.php';
                    }



                    public function Echoue(): void{
                        $etudiants= $this->getEtudiants();
                        $echoue= array_filter($etudiants, function($e){
                        return $e->getMoyenne() <10;
                });

                    require __DIR__ . '/../../views/ListesEchoue.php';
                    }
                    


                    //ajoute juste le formulaire a remplire
                    public function Ajouter(): void{
                        require __DIR__. '/../../views/Ajouter.php';
                    }



                   public function Creer(){ 
                        $nom = $_POST['nom']; 
                        $prenom = $_POST['prenom']; 
                        $age = (int)($_POST['age'] ?? 20); 
                        $moyenne = (float)$_POST['moyenne']; 
                        $filiere = $_POST['filiere']; 

                        $matricule = 'IAI' . str_pad((string)rand(1,9999), 4, '0', STR_PAD_LEFT); 

                        $query = "INSERT INTO etudiants (matricule, nom, prenom, age, moyenne, filiere) 
                                VALUES (:matricule, :nom, :prenom, :age, :moyenne, :filiere)"; 

                        $stmt = $this->db->prepare($query); 
                        $stmt->execute([ 
                            'matricule' => $matricule, 
                            'nom' => $nom, 
                            'prenom' => $prenom, 
                            'age' => $age, 
                            'moyenne' => $moyenne, 
                            'filiere' => $filiere
                        ]); 

                        header('Location: index.php?page=listes&tri=mention'); 
                        exit; 
                    }




                    public function getStat(): array{
                        $etudiants= $this-> getEtudiants();

                        $totale= count($etudiants);
                        $somme= 0;
                        $admis=0;

                        foreach ($etudiants as $ad) {
                            $somme += $ad-> getMoyenne();

                            if ($ad-> getMoyenne() >=10 ) {
                                $admis++;
                            }
                        }

                        $echoue= $totale - $admis;

                        if ($totale != 0) {
                            $taux= ($admis / $totale)*100;
                            $moyenneGenerale= $somme / $totale;
                        }
                        else {
                            $taux= 0;
                            $moyenneGenerale= 0;
                        }

                        return[
                            'total'=>$totale,
                            'admis'=> $admis,
                            'echoues'=> $echoue,
                            'taux'=> round($taux, 2),
                            'moyenneClasse'=> round($moyenneGenerale, 2)
                        ];
                    }

                }
?>