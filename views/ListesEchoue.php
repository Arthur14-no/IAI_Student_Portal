<?php require __DIR__ . '/layout/header.php'; ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
  <h1>Liste des Échoués</h1>
  <a href="index.php?page=listes" class="btn btn-secondary">↩ Retour</a>
</div>

<!--<div class="card">
  <div style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
    <a href="index.php?page=listes" class="btn btn-secondary">Toute la liste</a>
    <a href="index.php?page=admis" class="btn btn-secondary">Liste admis</a>
    <a href="index.php?page=echoue" class="btn btn-primary">Liste échoués</a>
    <a href="index.php?page=ajouter" class="btn btn-secondary">+ Ajouter</a>
  </div>-->

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; flex-wrap:wrap; gap:10px;">
    <h2 style="color:#dc2626; margin:0;">ÉCHOUÉS (<?= count($echoue) ?> étudiants)</h2>
    <input type="text" id="searchEchoue" placeholder="🔍 Rechercher..." class="input-iai" style="max-width:280px; margin:0;">
  </div>

  <table class="table-iai">
    <thead>
      <tr>
        <th>Matricule</th>
        <th>Nom & Prénom</th>
        <th>Moyenne</th>
        <th>Mention</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody id="tbodyEchoue">
      <?php foreach ($echoue as $ad): ?>
      <tr>
        <td><strong><?= $ad->getMatricul() ?></strong></td>
        <td><?= $ad->getNom() ?> <?= $ad->getPrenom() ?></td>
        <td><strong><?= $ad->getMoyenne() ?> /20</strong></td>
        <td><?= $ad->getMention() ?></td>
        <td><span class="badge badge-echoue">Échoué</span></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php if(empty($echoue)): ?>
    <p style="text-align:center; padding:20px;">Aucun échoué !</p>
  <?php endif; ?>
</div>

<script>
document.getElementById('searchEchoue').addEventListener('input', function(){
  let q = this.value.toLowerCase();
  document.querySelectorAll('#tbodyEchoue tr').forEach(tr => {
    tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>
