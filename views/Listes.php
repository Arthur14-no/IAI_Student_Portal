<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Etudiants</title>
</head>
<body>
    
    <nav>
        <a href="index.php?page=admis">liste des admis</a>
        <a href="index.php?page=echoue">Listes des echoues</a>
        <a href="index.php?page=ajouter">Ajouter un nouveau etudiant</a>
    </nav>
        <h2>LISTE DES ETUDIANTS</h2>
    
    <?php foreach ($etudiants as $liste): ?>
    <p> <?= $liste-> Presenter() ?> - <?= $liste-> Moyenne() ?> </p>
    <?php endforeach; ?>
        
</body>
</html>