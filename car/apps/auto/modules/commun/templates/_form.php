<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('commun/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?idauto='.$form->getObject()->getIdauto() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('commun/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'commun/delete?idauto='.$form->getObject()->getIdauto(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['idpays']->renderLabel() ?></th>
        <td>
          <?php echo $form['idpays']->renderError() ?>
          <?php echo $form['idpays'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idville']->renderLabel() ?></th>
        <td>
          <?php echo $form['idville']->renderError() ?>
          <?php echo $form['idville'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idmodele']->renderLabel() ?></th>
        <td>
          <?php echo $form['idmodele']->renderError() ?>
          <?php echo $form['idmodele'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idmoteur']->renderLabel() ?></th>
        <td>
          <?php echo $form['idmoteur']->renderError() ?>
          <?php echo $form['idmoteur'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idtype']->renderLabel() ?></th>
        <td>
          <?php echo $form['idtype']->renderError() ?>
          <?php echo $form['idtype'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idetat']->renderLabel() ?></th>
        <td>
          <?php echo $form['idetat']->renderError() ?>
          <?php echo $form['idetat'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idcouleur']->renderLabel() ?></th>
        <td>
          <?php echo $form['idcouleur']->renderError() ?>
          <?php echo $form['idcouleur'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idcarosserie']->renderLabel() ?></th>
        <td>
          <?php echo $form['idcarosserie']->renderError() ?>
          <?php echo $form['idcarosserie'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['idboite']->renderLabel() ?></th>
        <td>
          <?php echo $form['idboite']->renderError() ?>
          <?php echo $form['idboite'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['anneecir']->renderLabel() ?></th>
        <td>
          <?php echo $form['anneecir']->renderError() ?>
          <?php echo $form['anneecir'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['moiscir']->renderLabel() ?></th>
        <td>
          <?php echo $form['moiscir']->renderError() ?>
          <?php echo $form['moiscir'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['anneeded']->renderLabel() ?></th>
        <td>
          <?php echo $form['anneeded']->renderError() ?>
          <?php echo $form['anneeded'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['moisded']->renderLabel() ?></th>
        <td>
          <?php echo $form['moisded']->renderError() ?>
          <?php echo $form['moisded'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['nbportes']->renderLabel() ?></th>
        <td>
          <?php echo $form['nbportes']->renderError() ?>
          <?php echo $form['nbportes'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pfiscale']->renderLabel() ?></th>
        <td>
          <?php echo $form['pfiscale']->renderError() ?>
          <?php echo $form['pfiscale'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['kilometrage']->renderLabel() ?></th>
        <td>
          <?php echo $form['kilometrage']->renderError() ?>
          <?php echo $form['kilometrage'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['cylindres']->renderLabel() ?></th>
        <td>
          <?php echo $form['cylindres']->renderError() ?>
          <?php echo $form['cylindres'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['prixstart']->renderLabel() ?></th>
        <td>
          <?php echo $form['prixstart']->renderError() ?>
          <?php echo $form['prixstart'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['reprise']->renderLabel() ?></th>
        <td>
          <?php echo $form['reprise']->renderError() ?>
          <?php echo $form['reprise'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['etranger']->renderLabel() ?></th>
        <td>
          <?php echo $form['etranger']->renderError() ?>
          <?php echo $form['etranger'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dedouane']->renderLabel() ?></th>
        <td>
          <?php echo $form['dedouane']->renderError() ?>
          <?php echo $form['dedouane'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['garantie']->renderLabel() ?></th>
        <td>
          <?php echo $form['garantie']->renderError() ?>
          <?php echo $form['garantie'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['urgent']->renderLabel() ?></th>
        <td>
          <?php echo $form['urgent']->renderError() ?>
          <?php echo $form['urgent'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['nonfumeur']->renderLabel() ?></th>
        <td>
          <?php echo $form['nonfumeur']->renderError() ?>
          <?php echo $form['nonfumeur'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['garaged']->renderLabel() ?></th>
        <td>
          <?php echo $form['garaged']->renderError() ?>
          <?php echo $form['garaged'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['hand']->renderLabel() ?></th>
        <td>
          <?php echo $form['hand']->renderError() ?>
          <?php echo $form['hand'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['anneegarantie']->renderLabel() ?></th>
        <td>
          <?php echo $form['anneegarantie']->renderError() ?>
          <?php echo $form['anneegarantie'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['active']->renderLabel() ?></th>
        <td>
          <?php echo $form['active']->renderError() ?>
          <?php echo $form['active'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
