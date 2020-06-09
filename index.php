<?php
session_start();
include 'controller.php';
require_once 'connexpdo.php';
echo '<!doctype html>
<html lang="fr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Air -ISEN · Bootstrap</title>n

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="CSS/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white border-bottom shadow-sm">
        <a id="mainTitle" class="navbar-brand" href="index.php">Air ISEN Search</a>
    </nav>
</header>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Bienvenue · Welcome · Bienvenidos</h1>
        <br><br>
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
                                Date de départ
                                <input type="date" class="form-control" name="departDate" placeholder="Départ le" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    Adultes (> 4 Ans) <input type="number" placeholder="Nombre d\'adultes" class="form-control" name="nbrAdultes" min="0" max="10" required>
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
</main>
</body>

<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>
<script src="JS/test.js"></script>
</html>';
