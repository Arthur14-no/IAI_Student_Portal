<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTES DES ADMIS</title>
</head>
<body>

    <a href="index.php?page=liste">liste des etudiant</a>
    <a href="index.php?page=echoue">Listes des echoues</a>
    
     <h2>ADMIS</h2>

    <?php foreach ($admis as $ad): ?>
    <p> <?= $ad-> Presenter() ?> - <?= $ad-> Moyenne()?> </p>
    <?php endforeach; ?>

</body>
</html>