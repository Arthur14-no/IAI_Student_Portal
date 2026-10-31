<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTES DES ADMIS</title>
</head>
<body bgcolor="silver" align="center">

     <nav>
       <p style="margin-top:20px; text-align:center;">
        <a href="index.php?page=echoue" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;">Listes des echoues</a>
        <a href="index.php?page=listes" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;" >liste des etudiants</a>
        <a href="index.php?page=ajouter" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;">Ajouter un nouveau etudiant</a>
     </p>
     </nav>
    
     <h2>ADMIS</h2>

    <?php foreach ($admis as $ad): ?>
    <p> <?= $ad-> Presenter() ?> - <?= $ad-> Moyenne()?> </p>
    <?php endforeach; ?>

</body>
</html>