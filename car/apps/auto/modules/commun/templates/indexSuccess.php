<h1>Car autos List</h1>

<table>
  <thead>
    <tr>
      <th>Idauto</th>
      <th>Idville</th>
      <th>Idpays</th>
      <th>Idmarque</th>
      <th>Idmodele</th>
      <th>Idmoteur</th>
      <th>Idtype</th>
      <th>Idetat</th>
      <th>Idcouleur</th>
      <th>Idcarosserie</th>
      <th>Idboite</th>
      <th>Anneecir</th>
      <th>Moiscir</th>
      <th>Anneeded</th>
      <th>Moisded</th>
      <th>Description</th>
      <th>Adresse ip</th>
      <th>Visitors</th>
      <th>Notevisiteur</th>
      <th>Nbnotevisiteur</th>
      <th>Noteadmin</th>
      <th>Nbnoteadmin</th>
      <th>Nbportes</th>
      <th>Pfiscale</th>
      <th>Kilometrage</th>
      <th>Cylindres</th>
      <th>Notedesign</th>
      <th>Nbnotedesign</th>
      <th>Noteperf</th>
      <th>Nbnoteperf</th>
      <th>Noteconf</th>
      <th>Nbnoteconf</th>
      <th>Notecond</th>
      <th>Nbnotecond</th>
      <th>Prixstart</th>
      <th>Reprise</th>
      <th>Etranger</th>
      <th>Dedouane</th>
      <th>Garantie</th>
      <th>Urgent</th>
      <th>Nonfumeur</th>
      <th>Garaged</th>
      <th>Hand</th>
      <th>Anneegarantie</th>
      <th>Active</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($car_autos as $car_auto): ?>
    <tr>
      <td><a href="<?php echo url_for('commun/edit?idauto='.$car_auto->getIdauto()) ?>"><?php echo $car_auto->getIdauto() ?></a></td>
      <td><?php echo $car_auto->getIdville() ?></td>
      <td><?php echo $car_auto->getIdpays() ?></td>
      <td><?php echo $car_auto->getIdmarque() ?></td>
      <td><?php echo $car_auto->getIdmodele() ?></td>
      <td><?php echo $car_auto->getIdmoteur() ?></td>
      <td><?php echo $car_auto->getIdtype() ?></td>
      <td><?php echo $car_auto->getIdetat() ?></td>
      <td><?php echo $car_auto->getIdcouleur() ?></td>
      <td><?php echo $car_auto->getIdcarosserie() ?></td>
      <td><?php echo $car_auto->getIdboite() ?></td>
      <td><?php echo $car_auto->getAnneecir() ?></td>
      <td><?php echo $car_auto->getMoiscir() ?></td>
      <td><?php echo $car_auto->getAnneeded() ?></td>
      <td><?php echo $car_auto->getMoisded() ?></td>
      <td><?php echo $car_auto->getDescription() ?></td>
      <td><?php echo $car_auto->getAdresseIp() ?></td>
      <td><?php echo $car_auto->getVisitors() ?></td>
      <td><?php echo $car_auto->getNotevisiteur() ?></td>
      <td><?php echo $car_auto->getNbnotevisiteur() ?></td>
      <td><?php echo $car_auto->getNoteadmin() ?></td>
      <td><?php echo $car_auto->getNbnoteadmin() ?></td>
      <td><?php echo $car_auto->getNbportes() ?></td>
      <td><?php echo $car_auto->getPfiscale() ?></td>
      <td><?php echo $car_auto->getKilometrage() ?></td>
      <td><?php echo $car_auto->getCylindres() ?></td>
      <td><?php echo $car_auto->getNotedesign() ?></td>
      <td><?php echo $car_auto->getNbnotedesign() ?></td>
      <td><?php echo $car_auto->getNoteperf() ?></td>
      <td><?php echo $car_auto->getNbnoteperf() ?></td>
      <td><?php echo $car_auto->getNoteconf() ?></td>
      <td><?php echo $car_auto->getNbnoteconf() ?></td>
      <td><?php echo $car_auto->getNotecond() ?></td>
      <td><?php echo $car_auto->getNbnotecond() ?></td>
      <td><?php echo $car_auto->getPrixstart() ?></td>
      <td><?php echo $car_auto->getReprise() ?></td>
      <td><?php echo $car_auto->getEtranger() ?></td>
      <td><?php echo $car_auto->getDedouane() ?></td>
      <td><?php echo $car_auto->getGarantie() ?></td>
      <td><?php echo $car_auto->getUrgent() ?></td>
      <td><?php echo $car_auto->getNonfumeur() ?></td>
      <td><?php echo $car_auto->getGaraged() ?></td>
      <td><?php echo $car_auto->getHand() ?></td>
      <td><?php echo $car_auto->getAnneegarantie() ?></td>
      <td><?php echo $car_auto->getActive() ?></td>
      <td><?php echo $car_auto->getCreatedAt() ?></td>
      <td><?php echo $car_auto->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('commun/new') ?>">New</a>
