<?php

  $nom_tournoi = filter_var(isset($_POST['nom_tournoi']), FILTER_SANITIZE_STRING);
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
      ':nom_tournoi' => $nom_tournoi
    );

  //création de la requête SQL
        $requeteSQL = "INSERT INTO Tournois (nom, date_debut, date_fin, descriptif, adresse) 
                VALUES (:nom_tournoi, '2019-11-11', '2019-11-12', 'blabla test', '10 rue test')";

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