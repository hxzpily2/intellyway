<table>
  <tbody>
    <tr>
      <th>Idamji statut:</th>
      <td><?php echo $amji_statut->getIdamjiStatut() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $amji_statut->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $amji_statut->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $amji_statut->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('statut/edit?idamji_statut='.$amji_statut->getIdamjiStatut()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('statut/index') ?>">List</a>
