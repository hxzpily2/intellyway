<h1>Amji types List</h1>

<table>
  <thead>
    <tr>
      <th>Idamji type</th>
      <th>Libelle</th>
      <th>Owner</th>
      <th>Description</th>
      <th>Active</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($amji_types as $amji_type): ?>
    <tr>
      <td><a href="<?php echo url_for('type/show?idamji_type='.$amji_type->getIdamjiType()) ?>"><?php echo $amji_type->getIdamjiType() ?></a></td>
      <td><?php echo $amji_type->getLibelle() ?></td>
      <td><?php echo $amji_type->getOwner() ?></td>
      <td><?php echo $amji_type->getDescription() ?></td>
      <td><?php echo $amji_type->getActive() ?></td>
      <td><?php echo $amji_type->getCreatedAt() ?></td>
      <td><?php echo $amji_type->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('type/new') ?>">New</a>
