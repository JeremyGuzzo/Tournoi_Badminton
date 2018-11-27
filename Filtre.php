<?php

  $databasehandler = connectionBDD();

  //------ récupération des données régions -----------------
  $statementRegion = $databasehandler->prepare("SELECT * FROM Regions ORDER BY nom");
  $statementRegion->execute();
  $tabRegions = $statementRegion->fetchAll(PDO::FETCH_ASSOC);
  $statementRegion->closeCursor();

  //------ récupération des données département -------------
  $statementDepartement = $databasehandler->prepare("SELECT * FROM Departements ORDER BY nom");
  $statementDepartement->execute();
  $tabDepartements = $statementDepartement->fetchAll(PDO::FETCH_ASSOC);
  $statementDepartement->closeCursor();

  //------ récupération des données catégories -------------
  $statementCategorie = $databasehandler->prepare("SELECT * FROM Categories ORDER BY nom");
  $statementCategorie->execute();
  $tabCategories = $statementCategorie->fetchAll(PDO::FETCH_ASSOC);
  $statementCategorie->closeCursor();

  //------ récupération des données types -------------
  $statementType = $databasehandler->prepare("SELECT * FROM Types ORDER BY id");
  $statementType->execute();
  $tabTypes = $statementType->fetchAll(PDO::FETCH_ASSOC);
  $statementType->closeCursor();

  //------ récupération des données classement -------------
  $statementClassement = $databasehandler->prepare("SELECT * FROM Classements ORDER BY id");
  $statementClassement->execute();
  $tabClassements = $statementClassement->fetchAll(PDO::FETCH_ASSOC);
  $statementClassement->closeCursor();

?>


<div id="filtres">
  FILTRES
  <form class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <h3>Lieu du tournoi:</h3>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Région</label>
              <select class="form-control">
              <option disabled selected>Selectionner</option>
              <?php foreach($tabRegions as $result) { ?>
                <option value="<?=$result['nom']?>">
                <?=$result['nom']?>
                </option>
              <?php
              }
              ?>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Département</label>
              <select class="form-control">
              <option disabled selected>Selectionner</option>
                <?php foreach($tabDepartements as $result) { ?>
                <option value="<?=$result['nom']?>">
                  <?=$result['nom']?>
                </option>
                <?php
                }
              ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6 categorie_type">
          <div class="form-group">
            <h3>Catégories autorisés:</h3>
            <?php foreach($tabCategories as $result) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="<?=$result['nom']?>">
                <label class="form-check-label" for="inlineCheckbox1"><?=$result['nom']?></label>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <h3>Types:</h3>
            <?php foreach($tabTypes as $result) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="<?=$result['nom']?>">
                <label class="form-check-label" for="inlineCheckbox2"><?=$result['nom']?></label>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <h3>Classements:</h3>
            <?php foreach($tabClassements as $result) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="<?=$result['nom']?>">
                <label class="form-check-label" for="inlineCheckbox2"><?=$result['nom']?></label>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label for="inputDate">Date de début</label>
            <input type="text" class="datepicker">
          </div>
        </div>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Reset Filtre</button>
    <button class="btn btn-primary" type="submit">Chercher</button>
  </form>
</div>