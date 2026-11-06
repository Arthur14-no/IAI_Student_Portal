<?php require __DIR__ . '/layout/header.php'; ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>Ajout nouvel étudiant</h1>
    <a href="index.php?page=listes" class="btn btn-secondary">← Retour</a>
</div>

<div class="card" style="max-width:650px; margin:0 auto;">
    <h2 style="text-align:center; margin-bottom:20px;">FORMULAIRE D'ENREGISTREMENT ETUDIANTS</h2>
    
    <form method="POST" action="index.php?page=creer">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input class="input-iai" type="text" name="nom" id="nom" required placeholder="EBODE">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input class="input-iai" type="text" name="prenom" id="prenom" required placeholder="Arthur">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label for="age">Age :</label>
                <input class="input-iai" type="number" name="age" id="age" required placeholder="EXP: 19">
            </div>
            <div class="form-group">
                <label for="filiere">Sélectionner la filière :</label>
                <select class="input-iai" name="filiere" id="filiere" required>
                    <option value="">Sélectionner la filière</option>
                    <option value="G.L">G.L</option>
                    <option value="S.R">S.R</option>
                    <option value="S.E">S.E</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="moyenne">Saisir la moyenne :</label>
            <input class="input-iai" type="number" name="moyenne" id="moyenne" min="0" max="20" step="0.01" required placeholder="EXP: 10.75">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px; padding:12px; font-size:16px;">Enregistrer</button>
    </form>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
