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
<main role="main" class="flex-shrink-0">
    <div class="container col-md-10">
        <h1 id="mainIntro" class="display-4 text-center">Vols Disponibles</h1>
        <br><br>

<div class="row">
    <div class="container col">';

    echo'</div>

<div class="container col-md-7">';

readFlights();
echo '</div>
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
<script src="JS/ajax.js"></script>

</html>';

?>