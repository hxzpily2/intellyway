<table>
  <tbody>
    <tr>
      <th>Idamji type:</th>
      <td><?php echo $amji_type->getIdamjiType() ?></td>
    </tr>
    <tr>
      <th>Libelle:</th>
      <td><?php echo $amji_type->getLibelle() ?></td>
    </tr>
    <tr>
      <th>Owner:</th>
      <td><?php echo $amji_type->getOwner() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $amji_type->getDescription() ?></td>
    </tr>
    <tr>
      <th>Active:</th>
      <td><?php echo $amji_type->getActive() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $amji_type->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $amji_type->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('type/edit?idamji_type='.$amji_type->getIdamjiType()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('type/index') ?>">List</a>
