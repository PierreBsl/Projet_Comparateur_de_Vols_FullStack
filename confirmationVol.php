<?php
include 'controller.php';
if ($_SESSION['active'] != 2 && $_SESSION['active'] != 3){
    if ($_SESSION['active'] == 0)
    {
        header("Location: index.php");
    }
    if ($_SESSION['active'] == 1){
        header("Location: affichageVol.php");
    }
}

$nbrAdults = $_SESSION['nbrAdultes'];
$nbrEnfants = $_SESSION['nbrEnfants'];

echo '<!DOCTYPE html>
<html lang="en" class="h-100">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Air ISEN · Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="CSS/style.css" rel="stylesheet">
    <!-- Custom Stylsheet for Maps API -->
    <link rel="stylesheet" href="https://js.arcgis.com/4.15/esri/themes/light/main.css">
    <script src="https://js.arcgis.com/4.15/"></script>
    <script>
  require([
      "esri/Map",
      "esri/views/MapView"
    ], function(Map, MapView) {

    var map = new Map({
      basemap: "topo-vector"
    });

    var view = new MapView({
      container: "viewDiv",
      map: map,
      center: [-118.80500, 34.02700], // longitude, latitude
      zoom: 13
    });
  });
  </script>
</head><body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white border-bottom shadow-sm justify-content-between">
        <a id="mainTitle" class="navbar-brand" href="index.php">Air ISEN Search</a>
        <div style="float: right">
            <a class="navbar-brand" href="connexion.php"><button type="button" class="btn btn-outline-white ">Connexion</button></a>
            <a class="navbar-brand" href="affichageAdmin.php"><button type="button" class="btn btn-outline-white">Admin</button></a>
        </div>
    </nav>
</header>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">';
if ($_SESSION['active']==3){
    echo '<div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Votre Réservation</h1>
        <br><br>
 <div class="row">
    <div class="col col-md-7">';
        displayCardByAdult();
        displayCardByChildren();

    echo '</div>
<div style="border-left:1px solid darkgrey;height:288px"></div>
    <div class="col">';

    displayCommande();

    echo '</div>';
}else {
    echo '<div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Vos Passagers</h1>
        <br><br>';
    flightCoordonate();
        echo '        
 <div class="row">
    <div class="col col-md-7">';
    echo '<form action="controller.php?func=createUser" method="post">';

    for ($i = 0; $i < $nbrAdults; $i++) {
        CreateFormAdult($i + 1);
    }
    for ($i = 0; $i < $nbrEnfants; $i++) {
        CreateFormEnfant($i + 1);
    }
    echo '<button name="validation" type ="submit" class="btn btn-lg btn-white" style="width: 100%">Valider</button>';
    echo '</form>';
    echo '</div>
<div style="border-left:1px solid darkgrey;height:208px"></div>
    <div class="col">';
    displayFlight();
    echo '<iframe style="width: 100%; height: 100%;" src="maps.php"></iframe></div>';
}
echo '
</div>
</main>
</body>
<br>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Developped by Pierre, Hugo, Tristan, Eloi @ 2020</span>
    </div>
</footer>
</html>';

?>