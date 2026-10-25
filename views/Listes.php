<?php $stats = $this->getStat(); ?>
<style>
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  max-width: 700px;
  margin: 15px auto;
}
.card {
  background: white;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  font-family: sans-serif;
}
.card b { font-size: 22px; display: block; }
.admis { border-left: 5px solid #22c55e; }
.echoue { border-left: 5px solid #ef4444; }
.taux { border-left: 5px solid #3b82f6; }
.moy { border-left: 5px solid #2c0e48; }
</style>


<h2>__DASHBOARD__</h2><br/>
<div class="stats-grid">
  <div class="card"><span>Total</span><b><?= $stats['total'] ?></b></div>
  <div class="card admis"><span>Admis</span><b><?= $stats['admis'] ?></b></div>
  <div class="card echoue"><span>Échoués</span><b><?= $stats['echoues'] ?></b></div>
  <div class="card taux"><span>Taux</span><b><?= $stats['taux'] ?>%</b></div>
</div>
<div style="text-align:center; margin-bottom:15px;">
  Moyenne générale de la classe : <b><?= $stats['moyenneClasse'] ?> / 20</b>
</div>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Etudiants</title>
</head>
<body bgcolor="silver"  align="center">
    
    <nav>
       <p>
        <a href="index.php?page=admis">liste des admis</a>
        <a href="index.php?page=echoue">Listes des echoues</a>
        <a href="index.php?page=ajouter">Ajouter un nouveau etudiant</a>
       </p>
    </nav>

    <nav>
       <p>
         <a href="index.php?page=listes&tri=moyenne">Moyennes 2>1.  </a>
        <a href="index.php?page=listes&tri=mention">Mention</a>
       </p>
    </nav>

         <h2>RECHERCHE PAR NOM/PRENOM</h2>
    <form action="index.php" method="GET"> 

        <p>
            <input type="hidden" name="page" id="page" value="listes">
            <fieldset>
                <legend>Veuiller saisir le nom/prenom</legend>

                <input type="text" name="q" id="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                <button type="submit">Rechercher</button>
            </fieldset>
        </p>

        <h2>LISTE DES ETUDIANTS</h2>
    
    <?php foreach ($etudiants as $liste): ?>
    <p> <?= $liste-> Presenter() ?> - <?= $liste-> Moyenne() ?> </p>
    <?php endforeach; ?>
        
</body>
</html>