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
                    // 1. pagination
                    $pageActuelle = isset($_GET['p']) ? (int)$_GET['p'] : 1;
                    if ($pageActuelle < 1) $pageActuelle = 1;
                    $parPage = 5;

                    $stmtCount = $this->db->query("SELECT COUNT(*) as total FROM etudiants");
                    $totalEtudiants = (int)$stmtCount->fetch()['total'];
                    $totalPages = (int)ceil($totalEtudiants / $parPage);
                    $offset = ($pageActuelle - 1) * $parPage;

                    // 2. LE FIX DU TRI - c'est ici que ça change
                    $tri = $_GET['tri'] ?? 'nom'; // par défaut A-Z
                    $orderBy = ($tri === 'moyenne') ? "moyenne DESC" : "nom ASC, prenom ASC";

                    $stmt = $this->db->prepare("SELECT * FROM etudiants ORDER BY $orderBy LIMIT :limit OFFSET :offset");
                    $stmt->bindValue(':limit', $parPage, \PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
                    $stmt->execute();
                    $etudiantsArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    // 3. retransformer en objets (tu gardes ton code)
                    $etudiants = [];
                    foreach($etudiantsArray as $row){
                        $etudiants[] = new \App\Models\Etudiant(
                            $row['nom'],
                            $row['prenom'],
                            (int)$row['age'],
                            (float)$row['moyenne'] ?? 20,
                            $row['filiere'] ?? $row['mention'],
                            $row['matricule']
                        );
                    }

                    // 4. recherche par noms (tu gardes ton code)
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


                public function exportPdf(): void {
                    while (ob_get_level()) { ob_end_clean(); }

                    $stmt = $this->db->query("SELECT * FROM etudiants ORDER BY nom ASC, prenom ASC");
                    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    // FPDF 1.9.0 que tu viens d'installer
                    $pdf = new \FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','B',16);
                    $pdf->Cell(0,10,'IAI Student Portal - Liste des Etudiants',0,1,'C');
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(0,8,'Total: '.count($rows).' | '.date('d/m/Y'),0,1,'C');
                    $pdf->Ln(5);

                    // En-tête tableau
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(25,10,'Matricule',1);
                    $pdf->Cell(35,10,'Nom',1);
                    $pdf->Cell(35,10,'Prenom',1);
                    $pdf->Cell(15,10,'Age',1);
                    $pdf->Cell(25,10,'Filiere',1);
                    $pdf->Cell(25,10,'Moyenne',1);
                    $pdf->Cell(30,10,'Mention',1);
                    $pdf->Ln();

                    // Lignes
                    $pdf->SetFont('Arial','',10);
                    foreach($rows as $r){
                        $mention = $r['moyenne'] >= 10 ? 'Admis' : 'Echoue';
                        $pdf->Cell(25,8,$r['matricule'],1);
                        $pdf->Cell(35,8,$r['nom'],1);
                        $pdf->Cell(35,8,$r['prenom'],1);
                        $pdf->Cell(15,8,$r['age'],1);
                        $pdf->Cell(25,8,$r['filiere'],1);
                        $pdf->Cell(25,8,$r['moyenne'],1);
                        $pdf->Cell(30,8,$mention,1);
                        $pdf->Ln();
                    }

                    $pdf->Output('D','liste_etudiants.pdf');
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
                       $echoue = array_filter($etudiants, function($e){ return $e->getMoyenne() <10; });
                            usort($echoue, function($a,$b){ return $b->getMoyenne() <=> $a->getMoyenne(); });


                    require __DIR__ . '/../../views/ListesEchoue.php';
                    }
                    


                    //ajoute juste le formulaire a remplire
                    public function Ajouter(): void{
                        require __DIR__. '/../../views/Ajouter.php';
                    }


                    // ajouter un nouvel etudiant
                   public function Creer(){
                        $nom = trim($_POST['nom'] ?? '');
                        $prenom = trim($_POST['prenom'] ?? '');
                        $age = (int)($_POST['age'] ?? 20);
                        $moyenne = (float)($_POST['moyenne'] ?? 0);
                        $filiere = $_POST['filiere'] ?? 'G.L';

                        // validations IAI
                        if($nom === '' || $prenom === '') { 
                            header('Location: index.php?page=ajouter&error=nom'); exit; 
                        }
                        if($age < 15 || $age > 60) $age = 20;
                        if($moyenne < 0 || $moyenne > 20) $moyenne = 0;
                        if(!in_array($filiere, ['G.L','S.R'])) $filiere = 'G.L';

                        // Matricule SANS espace et unique
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

                        header('Location: index.php?page=listes&tri=moyenne');
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