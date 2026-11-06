<?php require __DIR__ . '/layout/header.php'; ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>Modifier l'étudiant <?= $etudiant['matricule'] ?></h1>
    <a href="index.php?page=listes" class="btn btn-secondary">← Retour</a>
</div>

<div class="card" style="max-width:650px; margin:0 auto;">
    <form method="POST" action="index.php?page=editer">
        <input type="hidden" name="matricule" value="<?= $etudiant['matricule'] ?>">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Nom :</label>
                <input class="input-iai" type="text" name="nom" value="<?= $etudiant['nom'] ?>" required>
            </div>
            <div class="form-group">
                <label>Prénom :</label>
                <input class="input-iai" type="text" name="prenom" value="<?= $etudiant['prenom'] ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Filière :</label>
            <select class="input-iai" name="filiere" required>
                <option value="G.L" <?= $etudiant['filiere'] == 'G.L' ? 'selected' : '' ?>>G.L - Génie Logiciel</option>
                <option value="S.R" <?= $etudiant['filiere'] == 'S.R' ? 'selected' : '' ?>>S.R - Systèmes & Réseaux</option>
                <option value="S.E" <?= $etudiant['filiere'] == 'S.E' ? 'selected' : '' ?>>S.E - Systèmes Électroniques</option>
            </select>
        </div>

        <div class="form-group">
            <label>Moyenne :</label>
            <input class="input-iai" type="number" step="0.01" min="0" max="20" name="moyenne" value="<?= $etudiant['moyenne'] ?>" required>
        </div>

        <div style="display:flex; gap:10px; margin-top:20px;">
            <button type="submit" class="btn btn-primary" style="flex:1; padding:12px;">Enregistrer</button>
            <a href="index.php?page=listes" class="btn btn-secondary" style="flex:1; text-align:center; padding:12px;">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
