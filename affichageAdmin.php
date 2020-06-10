<?php
include 'controller.php';
require_once 'connexpdo.php';



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
    <div class="container col-md-9">';

affichageAdmin();
        echo '</div>
     <br>
</form>
    </div>
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