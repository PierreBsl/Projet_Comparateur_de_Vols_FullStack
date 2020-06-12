<?php
include 'controller.php';
if ($_SESSION['active'] != 1 && $_SESSION['active']!=2){
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
    <link rel="icon" type="image/png" href="IMG/airplane-flight-around-the-planet.png" />
</head><body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm justify-content-between">
        <a id="mainTitle" class="navbar-brand" href="index.php" title="Accueil">
        <img src="IMG/airplane-flight-around-the-planet.svg" alt="Icone Air ISEN" style="width: 50px">
        &nbsp;Air ISEN Search</a>        
        <div style="float: right">
            <a class="navbar-brand" href="connexion.php"><button type="button" class="btn btn-outline-white ">Connexion</button></a>
            <a class="navbar-brand" href="admin/affichageAdmin.php"><button type="button" class="btn btn-outline-white">Admin</button></a>
        </div>
    </nav>
</header>
<img src="IMG/panorama.jpg" class="img-fluid" alt="Responsive image" style="max-width: 100%; height: auto;">
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container col-md-10">
        <h1 id="mainIntro" class="display-4 text-center">Vols Disponibles</h1>
        <br>
        <div class="container col-md-8">
            <ol style="background-color:white" class="breadcrumb justify-content-between">
                  <li ><a style="color: black" href="index.php"><i class="fa fa-search"></i>&nbsp;Recherche</a></li>
                  <li class="active"><a style="color: orangered"><i class="fa fa-plane"></i>&nbsp;Vols Disponibles</a></li>
                  <li class="disabled" style="color: darkgrey"><i class="fa fa-suitcase"></i>&nbsp;Passagers</li>
                  <li class="disabled" style="color: darkgrey"><i class="fa fa-credit-card-alt"></i>&nbsp;Réservation</li>
            </ol>
        </div>
        <br>
         <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item"><button id="jourPre" class="page-link">Précédent</button></li>
            <li class="page-item"><button id="jourActu" class="page-link">---</button></li>
            <li class="page-item"><button id="jourNext" class="page-link">Suivant</button></li>
          </ul>
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
                <span class="text-muted"><small id="actualOrder">Actuel : Croissant</small></span>
                <div class="row">
                    <div class="col-mx-auto"><button id="croissantButton"  style="margin-top: 4%; margin-bottom: -8%" type="button" class="btn btn-outline-white">Croissant</button></div>
                    &nbsp;<div class="col-mx-auto"><button id="decroissantButton"  style="margin-top: 4%; margin-bottom: -8%" type="button" class="btn btn-outline-white">Décroissant</button></div>
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
    <div class="container col-md-1" style="height: 500px;">
    </div>
     <br>
     <br>
     <br>
</main>
</body>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Développé par Pierre, Hugo, Tristan, Eloi @ 2020</span>
    </div>
</footer>
<script src="JS/price.js"></script>

</html>';

?>

