<h1>Amji statuts List</h1>

<table>
  <thead>
    <tr>
      <th>Idamji statut</th>
      <th>Libelle</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($amji_statuts as $amji_statut): ?>
    <tr>
      <td><a href="<?php echo url_for('statut/show?idamji_statut='.$amji_statut->getIdamjiStatut()) ?>"><?php echo $amji_statut->getIdamjiStatut() ?></a></td>
      <td><?php echo $amji_statut->getLibelle() ?></td>
      <td><?php echo $amji_statut->getCreatedAt() ?></td>
      <td><?php echo $amji_statut->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('statut/new') ?>">New</a>
