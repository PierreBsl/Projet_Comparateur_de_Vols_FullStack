<?php
include 'controller.php';
if ($_SESSION['active'] != 1){
    header("Location: index.php");
}

$depart = $_SESSION['originAirport'];
$arrivee = $_SESSION['destinationAirport'];
$date = $_SESSION['departDate'];
$nbrAdults = $_SESSION['nbrAdultes'];
$nbrEnfants = $_SESSION['nbrEnfants'];
$volDirect = $_SESSION['volDirectCheck'];

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link href="CSS/style.css" rel="stylesheet">
  
</head><body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm">
        <a id="mainTitle" class="navbar-brand" href="index.php">Air ISEN Search</a>
    </nav>
</header>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container col-md-10">
        <h1 id="mainIntro" class="display-4 text-center">Vols Disponibles</h1>
        <br><br>
<div class="row">
    <div class="container col">
            <div class="card">
            <div class="card-body">
              <div class="form-group">
                <h5>PRIX</h5><span class="text-muted"><small id="textSlide"></small></span>
                <input id="range" style="margin-top: 3%" type="range" min="0" max="100" class="form-control-range" step="1" value="0">
                <button id="searchButton"  style="margin-top: 4%; margin-bottom: -8%" type="button" class="btn btn-outline-white">Rechercher</button>
              </div>
              </div>
              </div>
              <br>
              <div class="card">
            <div class="card-body">
              <div class="form-group">
                <h5>ORDRE DE TRI</h5>
                <h6 id="actualOrder">Actuelle : Croissant</h6>
                <div class="row">
                    <div class="col-mx-auto"><button id="croissantButton"  style="margin-top: 4%; margin-bottom: -8%" type="button" class="btn btn-outline-white">Croissant</button></div>
                    &nbsp;<div class="col-mx-auto"><button id="decroissantButton"  style="margin-top: 4%; margin-bottom: -8%" type="button" class="btn btn-outline-white">Decroissant</button></div>
                    </div>
              </div>
              </div>
              </div>
   </div>
<div id="allCard" class="container col-md-6">

<div id="myNav" class="overlay" style="width: 100%">
   <div class="overlay-content">
        <div class="d-flex justify-content-center" style="color: orangered">
            <div class="spinner-border" role="status" style="width: 4rem; height: 4rem;"></div>
        </div>
   </div>
</div>

</div>

<div style="border-left:1px solid darkgrey;height:352px"></div>
    <div class="container col-md-3">
                <div class="card" style="height: 353px">
                <iframe src="https://fr.euronews.com/embed/timeline" scrolling="no" style="border:none; min-height:425px; width:100%; height:100%;"></iframe>
                </div>
    </div>
    <div class="container col-md-1">
    </div>
</main>
</body>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Developped by Pierre, Hugo, Tristan, Eloi @ 2020</span>
    </div>
</footer>
<script src="JS/price.js"></script>

</html>';

?>

