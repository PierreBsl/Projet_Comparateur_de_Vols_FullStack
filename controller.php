<?php

require_once 'connexpdo.php';
session_start();
if (isset($_GET["func"]))
{
    if ($_GET["func"]=="readFlights"){
        redirectFlights($_POST['originAirport'], $_POST['destinationAirport'], $_POST['departDate'], $_POST['nbrAdultes'], $_POST['nbrEnfants'], $_POST['volDirectCheck']);
    }
}

function redirectFlights($depart, $arrivee, $date, $nbrAdults, $nbrEnfants, $volDirect){
    header("Location: affichageVol.php");

    $_SESSION['originAirport']=$depart;
    $_SESSION['destinationAirport']=$arrivee;
    $_SESSION['departDate']=$date;
    $_SESSION['nbrAdultes']=$nbrAdults;
    $_SESSION['nbrEnfants']=$nbrEnfants;
    $_SESSION['volDirectCheck']=$volDirect;

}

function buildForm() {

    if (isset($_POST['originAirport']) && isset($_POST['destinationAirport']) && isset($_POST['departDate']) && isset($_POST['nbrAdultes']) && isset($_POST['nbrEnfants'])) {
        $nombreAdultes = $_POST['nbrAdultes'];
        $nombreEnfants = $_POST['nbrEnfants'];

        //$bdd = connexpdo('pgsql:dbname=avion;host=localhost;port=5432', 'postgres', 'new_password');
        //$query = $bdd->prepare("SELECT state FROM taxes WHERE city = " . $_POST['originAirport']);
        //$query->execute();
        //$result = $query->fetch();
        //print_r($result[0]);
        echo '<form action = "">';
        for ($i = 0; $i < $nombreAdultes; $i++) {
            CreateFormAdult($i + 1);
        }
        for ($i = 0; $i < $nombreEnfants; $i++) {
            CreateFormEnfant($i + 1);
        }
        echo '<button type ="submit" class="btn btn-lg btn-white" style="width: 66%">Valider</button>';
        echo '</form>';
    }
}

function readFlights(){
    global  $db;
    $depart = $_SESSION['originAirport'];
    $arrivee = $_SESSION['destinationAirport'];
    $date = $_SESSION['departDate'];
    $nbrAdults = $_SESSION['nbrAdultes'];
    $nbrEnfants = $_SESSION['nbrEnfants'];
    $volDirect = $_SESSION['volDirectCheck'];

    $nbPlace=$nbrAdults+$nbrEnfants;
    $route = " ".$depart."-".$arrivee;
    $route=" YOW-ZAC";
    echo $route;
    $unixTimestamp = strtotime($date);
    $dayOfWeek = date("w", $unixTimestamp); //dayoftime

    $nbr_Flight=0;

    $query = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
    $result = $db->prepare($query);
    $result->execute();
    $res = $result->fetchAll();
    foreach ($res as $data){
        $nbr_Flight++;
    }

    if($nbr_Flight>=1) {
        echo'<table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Route</th>
                <th scope="col">Distance</th>
                <th scope="col">Depart Time</th>
                <th scope="col">Arrival time</th>
                <th scope="col">Select</th>
            </tr>
        </thead>
        <tbody>';
        $query1 = "SELECT id, route, distancekm, departuretime, arrivaltime FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
        $sth = $db->prepare($query1);
        $sth->execute();
        $result=$sth->fetchAll();

        for ($k = 0; $k < $nbr_Flight; $k++) {
            $index=$k+1;
            echo '<tr>';
            echo '<th id="idStudent" scope="row">'.$index.'</th>';
            echo '<td>' . $result[$k]['id'] . '</td>';
            echo '<td>' . $result[$k]['route'] . '</td>';
            echo '<td>' . $result[$k]['distancekm'] . '</td>';
            echo '<td>' . $result[$k]['departuretime'] . '</td>';
            echo '<td>' . $result[$k]['arrivaltime'] . '</td>';
            echo '<td><input type="checkbox"></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }else{
        return;
    }

    echo "Nombre Flight: ".$nbr_Flight;



}

function CreateFormAdult($id){
    $today = getDate();
    $todayYear = $today['year'];
    $todayMonth = $today['mon'];
    $todayDay = $today['mday'];
    $lastYear = $todayYear-4;
    echo ' 
 <br>
 <div class="row">
    <div class="col col-md-8">
        <div class="card">
                    <div class="card-header">
                    Adulte n°'.$id.'
</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomAdult'.$id.'" placeholder="Nom">
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomAdult'.$id.'" placeholder="Prénom">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                            Adresse e-mail
                            <input type="email" class="form-control" name="emailAdult'.$id.'" placeholder="Adresse e-mail">
                        </div>
                        <div class="form-group col-md-6">
                          Date de Naissance
                          <input type="date" class="form-control" max="'.$lastYear.'-'.$todayMonth.'-'.$todayDay.'" name="birthAdult'.$id.'">
                        </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 ';
}

function CreateFormEnfant($id){
    $today = getDate();
    $todayYear = $today['year'];
    $todayMonth = $today['mon'];
    $todayDay = $today['mday'];
    $lastYear = $todayYear-4;
    echo ' 
 <br>
<div class="row">
    <div class="col col-md-8">
        <div class="card">
                            <div class="card-header">
                    Enfant n°'.$id.'
</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomEnfant'.$id.'" placeholder="Nom">
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomEnfant'.$id.'" placeholder="Prénom">
                    </div>
                </div>
                <div class="form-group">
                      Date de Naissance
                      <input type="date" class="form-control" min="'.$lastYear.'-'.$todayMonth.'-'.$todayDay.'" name="birthEnfant'.$id.'">
                </div>
            </div>
        </div>
    </div>
 </div>
 ';

}