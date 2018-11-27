<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="CSS.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>Tournoi Badminton</title>
  </head>

  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <header>
          <?php
          ini_set('display_errors', 1);
          ini_set('log_errors', 1);
          ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

          include "fonctions/connectionBDD.php";          
          include "Banniere.php";
          ?>
        </header>