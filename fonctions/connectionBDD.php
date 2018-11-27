<?php
  function connectionBDD(){
    $user = "student";
    $pass = "mot_de_passe";

    $databasehandler = new PDO('mysql:host=localhost;dbname=projet_bad;charset=utf8', $user, $pass);
    return $databasehandler;
  }

  function getAllListeTournois() {
    $databasehandler = connectionBDD();
    $statementTournoi = $databasehandler->prepare("SELECT * FROM Tournois ORDER BY date_debut");
    $statementTournoi->execute();
    $tabTournois = $statementTournoi->fetchAll(PDO::FETCH_ASSOC);
    $statementTournoi->closeCursor();
    return $tabTournois;
  }  

  function getAllTournoisSimpleInformation() {
    $databasehandler = connectionBDD();
    $sql = "SELECT T.id AS id_tournoi,
    T.nom AS nom_tournoi,
    T.date_debut, 
    T.date_fin,
    R.nom AS nom_region,
    D.nom AS nom_departement
    FROM Lieux
    INNER JOIN Tournois AS T ON Lieux.id_tournois = T.id
    INNER JOIN Departements AS D ON Lieux.id_departements = D.id
    INNER JOIN Regions AS R ON D.id_regions = R.id;";
    //------ récupération des données nom du tournoi, du departement et de la region, date de debut et fin-------------
    $statementNomRegionDepartement = $databasehandler->prepare($sql);
    $statementNomRegionDepartement->execute();
    $tabNomRegionDepartement = $statementNomRegionDepartement->fetchAll(PDO::FETCH_ASSOC);
    $statementNomRegionDepartement->closeCursor();
    return $tabNomRegionDepartement;
  }

  function getRegions(){
    $databasehandler = connectionBDD();
    //------ récupération des données régions -----------------
    $statementRegion = $databasehandler->prepare("SELECT * FROM Regions ORDER BY nom");
    $statementRegion->execute();
    $tabRegions = $statementRegion->fetchAll(PDO::FETCH_ASSOC);
    $statementRegion->closeCursor();
    return $tabRegions;
  }

  function getClassementsAutorisees($id) {
    $databasehandler = connectionBDD();
    $sqlstg = "SELECT DISTINCT Classements.id,
    Classements.nom AS nom_classement
    FROM Tournois AS T
    INNER JOIN Tournois_settings ON Tournois_settings.id_tournois = T.id
    INNER JOIN Classements ON Tournois_settings.id_classements = Classements.id
    WHERE T.id = ".$id.";";
    //------ récupération des données classements autorisé d'un tournoi-------------
    $statementClassementAutorise = $databasehandler->prepare($sqlstg);
    $statementClassementAutorise->execute();
    $tabClassementAutorise = $statementClassementAutorise->fetchAll(PDO::FETCH_ASSOC);
    $statementClassementAutorise->closeCursor();
    return $tabClassementAutorise;
  }

  function getCategoriesAutorisees($id) {
    $databasehandler = connectionBDD();
    //------ récupération des données categories autorisé d'un tournoi-------------
    $sqlstring = "SELECT DISTINCT Categories.id,
    Categories.nom AS nom_categories
    FROM Tournois
    LEFT JOIN  Tournois_settings ON Tournois.id = Tournois_settings.id_tournois
    LEFT JOIN Categories ON Categories.id = Tournois_settings.id_categories
    WHERE Tournois.id =".$id.";";
    $statementCategorieAutorise = $databasehandler->prepare($sqlstring);
    $statementCategorieAutorise->execute();
    $tabCategorieAutorise = $statementCategorieAutorise->fetchAll(PDO::FETCH_ASSOC);
    $statementCategorieAutorise->closeCursor();
    return $tabCategorieAutorise;
  }

  function getAllTournoisCompleteInformation () {
    $databasehandler = connectionBDD();
    $sql = "SELECT T.id AS id_tournoi,
    T.nom AS nom_tournoi,
    T.date_debut,
    T.date_fin,
    R.nom AS nom_region,
    D.nom AS nom_departement
    FROM Lieux
    INNER JOIN Tournois AS T ON Lieux.id_tournois = T.id
    INNER JOIN Departements AS D ON Lieux.id_departements = D.id
    INNER JOIN Regions AS R ON D.id_regions = R.id;";
    //------ récupération des données nom du tournoi, du departement et de la region, date de debut et fin-------------
    $statementNomRegionDepartement = $databasehandler->prepare($sql);
    $statementNomRegionDepartement->execute();
    $tabNomRegionDepartement = $statementNomRegionDepartement->fetchAll(PDO::FETCH_ASSOC);
    $statementNomRegionDepartement->closeCursor();
    return $tabNomRegionDepartement;
  }
?>