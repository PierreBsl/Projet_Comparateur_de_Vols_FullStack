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
</head><body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white border-bottom shadow-sm">
        <a id="mainTitle" class="navbar-brand" href="index.php">Air ISEN Search</a>
    </nav>
</header>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Votre Réservation</h1>
        <br><br>
 <div class="row">
    <div class="col col-md-7">';
if ($_SESSION['active']==3){
    for ($i = 0; $i < $nbrAdults; $i++) {
        displayCardByAdult();
    }
    for ($i = 0; $i < $nbrEnfants; $i++) {
        displayCardByChildren();
    }
    echo '</div>
<div style="border-left:1px solid darkgrey;height:288px"></div>
    <div class="col">';

    displayCommande();

    echo '</div>';
}else {
    echo '<form action="controller.php?func=createUser" method="post">';

    for ($i = 0; $i < $nbrAdults; $i++) {
        CreateFormAdult($i + 1);
    }
    for ($i = 0; $i < $nbrEnfants; $i++) {
        CreateFormEnfant($i + 1);
    }
    echo '<button name="validation" type ="submit" onclick="" class="btn btn-lg btn-white" style="width: 100%">Valider</button>';
    echo '</form>';
    echo '</div>
<div style="border-left:1px solid darkgrey;height:208px"></div>
    <div class="col">';
    displayFlight();
    echo '</div>';
}

echo '</main>
</body>
<br>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Developped by Pierre, Hugo, Tristan, Eloi @ 2020</span>
    </div>
</footer>
</html>';

?>