<?php

//vérifie si les donner rentré corresponde bien au type de la collone 
if (isset($_POST['marque'])){
  $filtreInput = filter_var($_POST['nomCategorie'], FILTER_SANITIZE_STRING);
}

if (isset($_POST['marque'])){
  $filtreInput = filter_var($_POST['valeur'], FILTER_SANITIZE_NUMBER_INT);
}

try{
  // initilisation de PDO
  // On stocke la connection à MySQL dans une variable en précisant le type de table, l'hote, le mon de la bdd, le pseudo et mot de passe
  $bdd = new PDO('mysql:host=localhost;dbname=MARTIN', 'root', 'root');
}

catch (Exception $e){
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : ' . $e->getMessage());
}

//récupération des valeurs des champs:

//isset /!\
$Event = $_POST['nomCategorie']; //filter var ou autre ntu
$Valeur = $_POST['valeur']; //ntu

//création de la requête SQL:
$sql = "INSERT INTO `CATEGORIE` (`nomCategorie`, `valeur`) VALUES (:ajoutEvent, :valeur)" ;
$req = $bdd->prepare($sql);
$req->bindValue(':ajoutEvent', $Event, PDO::PARAM_STR);
$req->bindValue(':valeur', $Valeur, PDO::PARAM_INT);
$req->execute();

// fermeture de la connection à la bdd
if($bdd){
  $bdd = NULL;
}
?>

-------------------------------------------------------------------------------
-------------------------------------------------------------------------------<?php

// ligne de filtres
  if(isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['email']) || isset($_POST['m_d_p'])) {
    if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['email']) || empty($_POST['m_d_p'])) {
      unset($_POST['nom']);
      unset($_POST['prenom']);
      unset($_POST['email']);
      unset($_POST['m_d_p']);
      ?>
         <script>alert("Champ vide")</script>
         <?php
    } else {
      $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
      $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
      $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
      $m_d_p = filter_var($_POST['m_d_p'], FILTER_SANITIZE_STRING);

      // Connexion BDD
      try { 
        $databasehandler = connectBDD();
      }

      // En cas d'erreur
      catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }

      // Création Tableau de valeur d'entrée
      $tab = array(
         ':nom' => $nom,
         ':prenom' => $prenom,
         ':email' => $email,
         ':m_d_p' => $m_d_p
       );

      //création de la requête SQL
            $requeteSQL = "INSERT INTO `Comptes_clients` (nom, prenom, email, mot_de_passe) 
                    VALUES (:nom, :prenom, :email, :m_d_p)";

      // ça, c'est juste le temps de comprendre
      echo $requeteSQL;

      // ???
      $createCompte = $databasehandler->prepare($requeteSQL);
        // cette méthode te retourne true/false si ça a réussi/échoué
      $result = $createCompte->execute($tab);

      // Du coup, on peux tester sur le retour et afficher l'erreur en cas de soucis
      if (!$result) {
        // ça t'affiche juste un code. C'est suffisant en prod pour que l'utilisateur te fasse un retour
        echo "Une erreur est survenue : " . $createCompte->errorCode();
        // Mais en dev, pour comprendre, tu peux faire ça :
        print_r($createCompte->errorInfo());
      }
      
      // fermeture de la connection à la bdd
      if ($databasehandler) {
          $databasehandler = NULL;
      }
    }	
  }
?>

-------------------------------------------------------------------------------


  <script>
  $( function() {
    $( ".datepicker" ).datepicker();
  } );
  </script>
 
<?php
  include "fonctions/connectionBDD.php";

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

  <div id="mainForm" class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h2>Renseignez les caractèristiques du tournoi</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="InscriptionTournoi.php" method="POST" class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col">
                  <label for="name"><h3> Nom du tournoi:</h3></label>
                  <input id="name" type="text" name="nom_tournoi" class="form-control" placeholder="...">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h3>Lieu du tournoi:</h3>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Région</label>
                  <select class="form-control" id="exampleFormControlSelect1">
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
                  <select class="form-control" id="exampleFormControlSelect2">
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
                <div class="form-group">
                  <label for="inputAddress">Addresse</label>
                  <input type="text" class="form-control" name="adresse" id="inputAddress" placeholder="10 Rue ....">
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
                <input type="date" name="date_debut">
              </div>
              <div class="form-group">
                <label for="inputDate">Date de fin</label>
                <input type="date" name="date_fin">
              </div>
            </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleFormControlFile1"><h3>Règlement du tournoi:</h3></label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1"><h3>Descriptif du tournoi:</h3></label>
                  <textarea class="form-control" name="descriptif" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </div>
            </div>
            <button class="btn btn-primary" type="submit">Inscrire</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

  $nom_tournoi = filter_var(isset($_POST['nom_tournoi']), FILTER_SANITIZE_STRING);
  $date_debut = filter_var(isset($_POST['date_debut']));
  $date_debut =substr($date_debut,6,4).'-'.substr($date_debut,0,2).'-'.substr($date_debut,3,2);echo $date_debut;
  $date_fin = filter_var(isset($_POST['date_fin']));
  $date_fin =substr($date_fin,6,4).'-'.substr($date_fin,0,2).'-'.substr($date_fin,3,2);echo $date_fin;
  $descriptif = filter_var(isset($_POST['descriptif']), FILTER_SANITIZE_STRING);
  $adresse = filter_var(isset($_POST['adresse']), FILTER_SANITIZE_STRING);

  // Connexion BDD
  try { 
    $databasehandler = connectionBDD();
  }

  // En cas d'erreur
  catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }

  // Création Tableau de valeur d'entrée
  $tab = array(
      ':nom_tournoi' => $nom_tournoi,
      ':date_debut' => $date_debut,
      ':date_fin' => $date_fin,
      ':descriptif' => $descriptif,
      ':adresse' => $adresse
    );

  //création de la requête SQL
        $requeteSQL = "INSERT INTO Tournois (nom, date_debut, date_fin, descriptif, adresse) 
                VALUES (:nom_tournoi, :date_debut, :date_fin, :descriptif, :adresse)";

  // ça, c'est juste le temps de comprendre
  echo $requeteSQL;

  // ???
  $inscrireTournoi = $databasehandler->prepare($requeteSQL);
    // cette méthode te retourne true/false si ça a réussi/échoué
  $result = $inscrireTournoi->execute($tab);

  // Du coup, on peux tester sur le retour et afficher l'erreur en cas de soucis
  if (!$result) {
    // ça t'affiche juste un code. C'est suffisant en prod pour que l'utilisateur te fasse un retour
    echo "Une erreur est survenue : " . $inscrireTournoi->errorCode();
    // Mais en dev, pour comprendre, tu peux faire ça :
    print_r($inscrireTournoi->errorInfo());
  }

  // fermeture de la connection à la bdd
  if ($databasehandler) {
      $databasehandler = NULL;
  }

?>