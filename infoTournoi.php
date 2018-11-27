<?php

  //------ récupération des données tournois -----------------
  $tournoisCompleteInfo = getAllTournoisCompleteInformation();
  

?>

<div id="detailTournoi">
  <h2>Détails du tournoi</h2>
  <?php foreach($tournoisCompleteInfo as $tournois) { ?>
    <div class="tournoi_inscris">
      <div><h3><?=$tournois['nom_tournoi']?></h3></div>
      <div>
        <div>Date de début: <?=$tournois['date_debut']?></div>
        <div>Date de fin: <?=$tournois['date_fin']?></div>
      </div>
      <div>
        <h4>Lieu:</h4>
        <div><?=$tournois['nom_region']?></div>
        <div><?=$tournois['nom_departement']?></div>
      </div>
      <div>
        <h4>Catégories admises:</h4>
        <?php
          $categorieAutorisees = getCategoriesAutorisees($tournois['id_tournoi']);
          foreach($categorieAutorisees as $categorie) { ?>
            <span><?=$categorie['nom_categories']?></span>
          <?php } ?>
      </div>
      <div>
        <h4>Classement admis:</h4>
        <?php
        $classementsAutorisees = getClassementsAutorisees($tournois['id_tournoi']);
        foreach($classementsAutorisees as $result2) { ?>
          <span><?=$result2['nom_classement']?></span>
        <?php
        }
        ?>
      </div>
      <div>
      <a href="detailTournoi.php"><button type="button" class="btn btn-primary btn-sm">Détails</button></a>
      </div>
    </div>
  <?php
  }
  ?>
</div>