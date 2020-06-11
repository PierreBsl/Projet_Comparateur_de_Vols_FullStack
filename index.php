<?php
include 'controller.php';
require_once 'connexpdo.php';

if ($_SESSION['active']==3){
    deleteReservation();;
}
$_SESSION["mailUser"]="";
$_SESSION["birthUser"]="";
$_SESSION["userId"]="";
$_SESSION['active']=0;

echo '<!doctype html>
<html lang="fr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Air ISEN · Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="CSS/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="IMG/airplane-flight-around-the-planet.png" />
</head>
<body class="d-flex flex-column h-100">
<div id="loading">
    <div id="myNav" class="overlay" style="width: 100%">
   <div class="overlay-content">
        <div class="d-flex justify-content-center" style="color: orangered">
            <div class="spinner-border" role="status" style="width: 4rem; height: 4rem;"></div>
        </div>
   </div>
</div>
</div>
<header>
    <!-- Fixed navbar -->
   <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm justify-content-between">
        <a id="mainTitle" class="navbar-brand" href="index.php" title="Accueil">
        <img src="IMG/airplane-flight-around-the-planet.svg" alt="Icone Air ISEN" style="width: 50px">
        &nbsp;Air ISEN Search</a>        
        <div style="float: right">
            <a class="navbar-brand" href="connexion.php"><button type="button" class="btn btn-outline-white ">Connexion</button></a>
            <a class="navbar-brand" href="affichageAdmin.php"><button type="button" class="btn btn-outline-white">Admin</button></a>
        </div>
    </nav>
</header>
<img src="IMG/panorama.jpg" class="img-fluid" alt="Responsive image" style="max-width: 100%; height: auto;">

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Bienvenue · Welcome · Bienvenidos</h1>';
if (isset($_GET["error"]))
{
    if ($_GET["error"]=="villedepart"){
        echo '<div class="alert alert-danger" role="alert">L\'aéroport d\'arrivée n\'existe pas !</div>';
    }
    if ($_GET["error"]=="villearrivee"){
        echo '<div class="alert alert-danger" role="alert">L\'aéroport d\'arrivée n\'existe pas !</div>';
    }
    if ($_GET["error"]=="trajetvide"){
        echo '<div class="alert alert-warning" role="alert">Aucun vols pour ce jour-ci</div>';
    }
    if ($_GET["error"]=="confirm"){
        echo '<div class="alert alert-success" role="alert">Votre Réservation à bien été enregistrée. Vous pouvez la consulter sur votre espace Client</div>';
    }
    if ($_GET["error"]=="cancelled"){
        echo '<div class="alert alert-success" role="alert">Votre Réservation à bien été annulée</div>';
    }
    if ($_GET["error"]=="noaccount"){
        echo '<div class="alert alert-warning" role="alert">Vous n avez pas de billet à votre nom !</div>';
    }
    if ($_GET["error"]=="stopBillet"){
        echo '<div class="alert alert-warning" role="alert">Pas de billet sur le compte !</div>';
    }
    if ($_GET["error"] == "troppassager"){
        echo '<div class="alert alert-warning" role="alert">Limité à 9 reservations !</div>';
    }

}

echo '       <br><br>
        <div class="row">
            <div class="col col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="controller.php?func=readFlights" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6"> 
                                    Aéroport de départ
                                    <input type="text" class="form-control" name="originAirport" list="iddata1" autocomplete="off" placeholder="D\'où partez-vous ?" required>
                                    <datalist id="iddata1">
                                        <select name="ville3" id="ville3"></select>
                                    </datalist>
                                </div>
                                <div class="form-group col-md-6">
                                    Aéroport d\'arrivée
                                    <input type="text" class="form-control" name="destinationAirport" list="iddata2" autocomplete="off" placeholder="Où allez-vous ?" required>
                                    <datalist id="iddata2">
                                        <select name="ville2" id="ville2"></select>
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group">
                                Date de départ';
$today = date("Y-m-d");
echo '<input type="date" class="form-control" min="'.$today.'" name="departDate" placeholder="Départ le" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    Adultes (> 4 Ans) <input type="number" placeholder="Nombre d\'adultes" class="form-control" name="nbrAdultes" min="1" max="10" required>
                                </div>
                                <div class="form-group col-md-6">
                                    Enfants ( 0-4 Ans) <input type="number" placeholder="Nombre d\'enfants" class="form-control" name="nbrEnfants" min="0" max="10" required>
                                </div>
                            </div>
                            <div id="volDirectCheck" class="form-group col-md-6">
                                <input class="form-check-input" type="checkbox" name="volDirectCheck" value="1">
                                Vol direct
                            </div>
                            <button type="submit" class="btn btn-white">Suivant</button>
                        </form>
                    </div>
                </div>
            </div>
            <div style="border-left:1px solid darkgrey;height:352px"></div>
            <div class="col">
                <div class="card" style="height: 353px">
                <iframe src="https://fr.euronews.com/embed/timeline" scrolling="no" style="border:none; min-height:425px; width:100%; height:100%;"></iframe>
                </div>
            </div>
        </div>
     <br>
</form>
    </div>
    <br>
    <br>
    <br>
</main>
</body>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Developped by Pierre, Hugo, Tristan, Eloi @ 2020</span>
    </div>
</footer>
<script src="JS/ajax.js"></script>
</html>';