<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTES DES ECHOUES</title>
</head>
<body>
    
    <a href="index.php?page=liste">liste des etudiants</a>
    <a href="index.php?page=admis">Listes des admis</a>

    <h2>ECHOUES</h2>

    <?php foreach ($echoue as $ech): ?>
    <p> <?= $ech-> Presenter() ?> - <?= $ech-> Moyenne() ?> </p>
    <?php endforeach; ?>

</body>
</html>