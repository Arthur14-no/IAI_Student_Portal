<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAI Student Portal</title>
    <link rel="icon" type="image/png" href="img/logo-iai.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="iai-nav">
        <div class="container" style="display:flex; align-items:center;">
            <div class="iai-logo" style="display:flex; align-items:center; gap:10px;">
                <img src="img/logo-iai.png" style="height:36px; background:white; border-radius:50%; padding:2px;">
                <span>IAI | STUDENT PORTAL</span>
            </div>
        </div>
    </nav>

    </nav>

<?php $current = $_GET['page'] ?? 'listes'; ?>
<div class="iai-subnav">
  <div class="container" style="display:flex; gap:8px; flex-wrap:wrap; justify-content:center;">
    <a href="index.php?page=listes" class="nav-btn <?= $current == 'listes' ? 'active' : '' ?>">Toute la liste</a>
    <a href="index.php?page=admis" class="nav-btn <?= $current == 'admis' ? 'active' : '' ?>">Liste admis</a>
    <a href="index.php?page=echoue" class="nav-btn <?= $current == 'echoue' ? 'active' : '' ?>">Liste échoués</a>
    <a href="index.php?page=ajouter" class="nav-btn nav-btn-add <?= $current == 'ajouter' ? 'active' : '' ?>">+ Ajouter</a>
  </div>
</div>

    <main class="main-content">
        <div class="container">
            
