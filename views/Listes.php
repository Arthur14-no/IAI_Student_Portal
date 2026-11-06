<?php require __DIR__ . '/layout/header.php'; ?>
<?php $stats = $this->getStat(); ?>

<!-- DASHBOARD STATS - version IAI pro -->
<div class="stats-grid" style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px;">
  <a href="index.php?page=listes" class="stat-card-link">
    <div class="stat-card">
      <span>TOTAL</span><strong><?= $stats['total'] ?></strong>
    </div>
  </a>

  <a href="index.php?page=admis" class="stat-card-link">
    <div class="stat-card">
      <span>ADMIS</span><strong><?= $stats['admis'] ?></strong>
    </div>
  </a>

  <a href="index.php?page=echoue" class="stat-card-link">
    <div class="stat-card">
      <span>ÉCHOUÉS</span><strong><?= $stats['echoues'] ?></strong>
    </div>
  </a>

  <a href="index.php?page=admis" class="stat-card-link">
    <div class="stat-card">
      <span>TAUX D'ADMISSION</span><strong><?= $stats['taux'] ?>%</strong>
    </div>
  </a>
</div>


<!-- FILTRES -->
<!--<div class="card" style="margin-bottom:20px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
  <a href="index.php?page=listes" class="btn btn-secondary">Toute la liste</a>
  <a href="index.php?page=admis" class="btn btn-secondary">Liste admis</a>
  <a href="index.php?page=echoue" class="btn btn-secondary">Liste échoués</a>
  <a href="index.php?page=ajouter" class="btn btn-primary">+ Ajouter</a>
  <a href="index.php?page=export_pdf" target="_blank" class="btn btn-danger">Export PDF</a>
</div>-->

<!-- BARRE OUTILS FUSIONNÉE - Recherche + Tri + Export -->
<div class="card toolbar">
  <!-- À gauche : Recherche -->
  <form action="index.php" method="GET" class="toolbar-search">
    <input type="hidden" name="page" value="listes">
    <input type="hidden" name="tri" value="<?= $_GET['tri'] ?? 'moyenne' ?>">
    <input class="input-iai" type="text" name="q" placeholder="Rechercher par nom / prénom" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
    <button type="submit" class="btn btn-primary">Rechercher</button>
  </form>

  <!-- À droite : Actions -->
  <div class="toolbar-actions">
    <a href="index.php?page=listes&tri=nom" class="btn btn-primary">Tri Nom A-Z</a>
    <a href="index.php?page=listes&tri=moyenne" class="btn btn-primary">Tri Moyenne</a>
    <a href="index.php?page=export_pdf" target="_blank" class="btn btn-primary">Export PDF</a>
  </div>
</div>


</div>

  <table class="table-iai">
    <thead><tr><th>MATRICULE</th><th>NOM_COMPLET</th><th>AGE</th><th>FILIERE</th><TH>MOYENNE</TH><TH>MENTION</TH><TH>ACTION</TH></tr></thead>
    <tbody>
      <?php foreach ($etudiants as $e): ?>
      <tr>
        <td><?= $e->getMatricul() ?></td>
        <td><?= $e->getNom() ?> <?= $e->getPrenom() ?></td>
        <td><?= $e->getAge() ?> ans</td>
        <td><?= $e->getFilier() ?></td>
        <td><?= $e->getMoyenne() ?></td>
        <td><span class="badge <?= $e->isAdmis() ? 'badge-admis' : 'badge-echoue' ?>"><?= $e->getMention() ?></span></td>

          <td>
              <a href="index.php?page=editer&matricule=<?= $e->getMatricul() ?>" class="btn btn-secondary">Modifier</a>
              <a href="index.php?page=supprimer&matricule=<?= $e->getMatricul() ?>" class="btn btn-danger" onclick="return confirm('Voulez vraiment supprimer : <?= $e-> getMatricul() ?>')">Suppr.</a>
          </td>

      </tr>
      <?php endforeach; ?>
    </tbody>

  </table>

  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i == $pageActuelle): ?>
        <strong><?= $i ?></strong>
      <?php else: ?>
        <a href="?page=listes&tri=<?= $_GET['tri'] ?? 'moyenne' ?>&q=<?= $_GET['q'] ?? '' ?>&p=<?= $i ?>" class="btn <?= ($i == $pageActuelle) ? 'btn-primary' : 'btn-secondary' ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
