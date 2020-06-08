
<!DOCTYPE html>
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
    <div class="container col-md-9">
        <h1 id="mainIntro" class="display-4 text-center">Bienvenue · Welcome · Bienvenido</h1>
        <br><br>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    Aéroport de départ
                                    <input id="originAirport" type="url" list="iddata1">
                                    <datalist id="iddata1">
                                        <label for="ville1">ou sélectionner dans la liste</label>
                                        <select name="ville1" id="ville1"></select>
                                    </datalist>
                                </div>
                                <div class="form-group col-md-6">
                                    Aéroport d'arrivée
                                    <input id="destinationAirport" type="url" list="iddata2">
                                    <datalist id="iddata2">
                                        <label for="ville2">ou sélectionner dans la liste</label>
                                        <select name="ville2" id="ville2"></select>
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group">
                                Date de départ
                                <input type="date" class="form-control" id="departDate" placeholder="Départ le">
                            </div>
                            <div class="form-group">

                                <input type="number" class="form-control" id="departDate" placeholder="Départ le">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="volDirectCheck">
                                    Vol direct
                                </div>
                            </div>
                            <button type="submit" class="btn btn-white">Suivant</button>
                        </form>

                    </div>
                </div>
            </div>
            <div style="border-left:1px solid #000;height:460px"></div>
            <div class="col">
                <p>Suggestions: <span id="txtHint"></span></p>

            </div>

</main>
<script src="JS/test.js"></script>
</body>
<footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
    <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
    </div>
</footer>
</html>

