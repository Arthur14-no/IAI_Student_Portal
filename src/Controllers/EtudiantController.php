<?php
     declare(strict_types=1);

                //ici on renseigne ladresse du fichier grace au composer.
                namespace App\controllers;


                //ici on precise quil utilise la classe etudiant.
                use App\Models\Etudiant;

                // a defaut de creer des objet a part et de les rensigner dans lindex on creer une fois une classe index qui va eter appler dans index.php.
                class Etudiantcontroller{

                   private function getEtudiants(){
                        if (!isset($_SESSION['etudiants'])) {

                            $_SESSION['etudiants']= [
                                new Etudiant('IAI0001','ebode', 'salomon', 21, 11, 'G.L'),
                                new Etudiant('fouegue', 'erwan', 19, 10, 'S.R'),
                                new Etudiant('ekobo', 'bernard', 20, 15, 'G.L'),
                                new Etudiant('ze', 'benjo', 25, 8.5, 'S.R'),
                                new Etudiant('ngoula', 'sammy', 18, 9.5, 'G.L')
                            ];
                        }
                        return $_SESSION['etudiants'];
                    } 
                        
                
         /*       //pour afficher essentiellements les etudiants qui ont reussis.
                echo "<H2> ADMIS </H2>";
                foreach($admis as $ad){
                        echo $ad-> Presenter();
                        echo "-";
                        echo $ad-> Moyenne();
                        echo "<br/><br/>";

                }


                echo "<h2> ECHECS </h2>";
                foreach ($echoue as $key => $ech) {
                        echo $ech-> Presenter();
                        echo "-";
                        echo $ech-> Moyenne();
                        echo "<br/><br/>";
                }


                //cette boucle permet dafficher les valeur du tableu $etudiants
                echo "<h2> LISTES DES ETUDIANTS </h2><br/>";
                foreach($etudiants as $key=> $liste){
                echo $liste-> Presenter();
                echo $liste-> Moyenne();
                echo '<br/><br/>';
               };
        */
                    public function Listes(): void{
                        $etudiants= $this->getEtudiants();

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
                        if (isset($_POST['nom'])) {
                            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['filiere']) && !empty($_POST['moyenne']) && !empty($_POST['age']))  {
                               
                            $etudiants= $this-> getEtudiants();
                            
                            $nouvelEtudiant= new \App\Models\Etudiant(
                               $nom= $_POST['nom'],
                               $prenom= $_POST['prenom'],
                               $age= (int)$_POST['age'],
                               $moyenne= (float) $_POST['moyenne'],
                               $filiere= $_POST['filiere'],
                            );

                            $etudiants[]= $nouvelEtudiant;
                            $_SESSION['etudiants']= $etudiants;

                            header('location: index.php?page=liste');
                            exit();

                            }

                            else {
                                echo "erreur, champs all obligatoire";
                            }

                        }
                        else {
                            echo "aucune donnes";
                        }
                    }

                }
?>