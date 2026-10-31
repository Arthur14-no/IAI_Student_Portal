<?php
     declare(strict_types=1);

     namespace App\controllers;

     use App\config\Database;

                //ici on renseigne ladresse du fichier grace au composer.
              


                //ici on precise quil utilise la classe etudiant.
                use App\Models\Etudiant;

                // a defaut de creer des objet a part et de les rensigner dans lindex on creer une fois une classe index qui va eter appler dans index.php.
                class Etudiantcontroller{


                private $db;

                public function __construct(){
                    
                    $database= new Database();
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
                        
                
                public function listes(): void { 
                    // pagination de la liste des etudiants
                    $pageActuelle = isset($_GET['p']) ? (int)$_GET['p'] : 1; 
                    if ($pageActuelle < 1) $pageActuelle = 1; 
                    $parPage = 5; 

                    // compter avec $this->db
                    $stmtCount = $this-> db-> query("SELECT COUNT(*) as total FROM etudiants");
                    $totalEtudiants = (int)$stmtCount->fetch()['total'];
                    $totalPages = (int)ceil($totalEtudiants / $parPage); 
                    $offset = ($pageActuelle - 1) * $parPage; 

                    // recuperer 5 étudiants avec $this->db
                    $stmt = $this->db->prepare("SELECT * FROM etudiants ORDER BY moyenne DESC LIMIT :limit OFFSET :offset");
                    $stmt->bindValue(':limit', $parPage, \PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
                    $stmt->execute();
                    $etudiantsArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    
                    //  retransformer les valeur en objets apre lexecution evac la bd 
                    $etudiants = [];
                    foreach($etudiantsArray as $row){
                        $etudiants[]= new \App\Models\Etudiant(
                        $row['nom'],
                        $row['prenom'],
                        (int)$row['age'],
                        (float)$row['moyenne'] ?? 20,
                        $row['filiere'] ?? $row['mention'],
                        $row['matricule']
                        );
                    }

                    // tri par moyenne
                    if (isset($_GET['tri']) && $_GET['tri'] === 'moyenne') {
                        usort($etudiants, function($a, $b){
                            if ($a->getMoyenne() == $b->getMoyenne()) return 0;
                            return ($a->getMoyenne() < $b->getMoyenne()) ? 1 : -1;
                        });
                    }

                    // recherche par noms
                    if (isset($_GET['q']) && !empty($_GET['q'])) {
                        $motCle = strtolower($_GET['q']);
                        $filtre = [];
                        foreach ($etudiants as $unEtudiant) {
                            $nomComplet = strtolower($unEtudiant->getNom() . ' ' . $unEtudiant->getPrenom());
                            if (strpos($nomComplet, $motCle) !== false) {
                                $filtre[] = $unEtudiant;
                            }
                        }
                        $etudiants = $filtre;
                    }

                    require __DIR__ . '/../../views/Listes.php'; 
                }


              public function exportPdf(): void
{
                    while (ob_get_level()) { ob_end_clean(); }

                    // On ne passe PAS par getEtudiants() qui fait des echo
                    $stmt = $this->db->query("SELECT * FROM etudiants");
                    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    $html = '<h1 style="text-align:center;">Liste des Etudiants - IAI</h1>';
                    $html .= '<p>Total: '.count($rows).' | '.date('d/m/Y').'</p>';
                    $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
                    $html .= '<tr><th>Matricule</th><th>Nom</th><th>Prenom</th><th>Filiere</th><th>Moyenne</th></tr>';
                    
                    foreach($rows as $r){
                        $html .= '<tr>';
                        $html .= '<td>'.$r['matricule'].'</td>';
                        $html .= '<td>'.$r['nom'].'</td>';
                        $html .= '<td>'.$r['prenom'].'</td>';
                        $html .= '<td>'.$r['filiere'].'</td>';
                        $html .= '<td>'.$r['moyenne'].'</td>';
                        $html .= '</tr>';
                    }
                    $html .= '</table>';

                    $dompdf = new \Dompdf\Dompdf();
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream("liste_etudiants.pdf", ["Attachment" => false]);
                    exit;
                }


                    //cette fontion va permettre de filtrer les etudiant ayant eu >=10 ou <10.
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


                    // ajouter un nouvel etudiant
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


                    public function Supprimer(): void{
                        $matricule= $_GET['matricule'] ?? '';

                        if ($matricule === '') {
                            $_SESSION['message'] = "Matricule invalide";
                            header('Location: index.php?page=listes');
                            exit;
                        }

                        $stmt= $this-> db-> prepare("DELETE FROM etudiants WHERE matricule = ?");
                        $stmt-> execute([$matricule]);

                        $_SESSION['message']= "Etudiant $matricule supprimé !";
                        header('Location: index.php?page=listes');

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

                    public function getMatricule(string $matricule){

                        $stmt= $this-> db-> prepare ("SELECT * FROM etudiants WHERE matricule= ?");
                        $stmt-> execute([$matricule]);
                        return $stmt->fetch(\PDO::FETCH_ASSOC);
                    }

                    public function Editer(): void{

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $matricule= $_POST['matricule'];
                            $nom= $_POST['nom'];
                            $prenom= $_POST['prenom'];
                            $filiere= $_POST['filiere'];
                            $moyenne= $_POST['moyenne'];

                            $stmt= $this-> db-> prepare('UPDATE etudiants SET nom=?, prenom=?, filiere=?, moyenne=? WHERE matricule=?');
                            $stmt-> execute([$nom, $prenom, $filiere, $moyenne, $matricule]);

                            header('location: index.php?page=listes');
                            exit;
                        }

                        $matricule= $_GET['matricule'] ?? '';
                        $etudiant= $this->getMatricule($matricule);

                        if (!$etudiant) {
                            die("etudiant introuvable");
                        }

                        require __DIR__. '/../../views/editer.php';
                    }

                }

?>