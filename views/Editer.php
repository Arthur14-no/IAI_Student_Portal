<h2>Modifier l'étudiant <?= $etudiant['matricule'] ?></h2>

<form method="POST" action="index.php?page=editer">
    <input type="hidden" name="matricule" value="<?= $etudiant['matricule'] ?>">
    
    <label>Nom: <input type="text" name="nom" value="<?= $etudiant['nom'] ?>"></label><br>
    <label>Prenom: <input type="text" name="prenom" value="<?= $etudiant['prenom'] ?>"></label><br>
    <label>Filiere: <input type="text" name="filiere" value="<?= $etudiant['filiere'] ?>"></label><br>
    <label>Moyenne: <input type="number" step="0.01" name="moyenne" value="<?= $etudiant['moyenne'] ?>"></label><br>
    
    <button type="submit">Enregistrer</button>
    <a href="index.php?page=listes">Annuler</a>
</form>
