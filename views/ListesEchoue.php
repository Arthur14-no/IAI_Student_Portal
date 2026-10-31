<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTES DES ECHOUES</title>
</head>
<body bgcolor="silver" align="center">
    
    <nav>
       <p style="margin-top:20px; text-align:center;">
        <a href="index.php?page=admis" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white; ">liste des admis</a>
        <a href="index.php?page=ajouter" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;">Ajouter un nouveau etudiant</a>
        <a href="index.php?page=listes" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;" >liste des etudiants</a>
     </p>
     </nav>

    <h2>ECHOUES</h2>

    <?php foreach ($echoue as $ech): ?>
    <p> <?= $ech-> Presenter() ?> - <?= $ech-> Moyenne() ?> </p>
    <?php endforeach; ?>

</body>
</html>