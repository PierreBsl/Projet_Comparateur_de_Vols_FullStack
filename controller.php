<?php

require_once 'connexpdo.php';
session_start();
if (isset($_GET["func"]))
{
    if ($_GET["func"]=="readFlights"){
        redirectFlights($_POST['originAirport'], $_POST['destinationAirport'], $_POST['departDate'], $_POST['nbrAdultes'], $_POST['nbrEnfants'], $_POST['volDirectCheck']);
    }
    if ($_GET["func"]=="selectedFlight"){
        selectedFlight($_GET['id']);
    }
}

function selectedFlight($idVol){
    global  $db;

    $query1 = "SELECT route, distancekm, departuretime, arrivaltime FROM flights WHERE id ='".$idVol."'";
    $sth = $db->prepare($query1);
    $sth->execute();
    $result=$sth->fetchAll();

    $_SESSION['selectedVolId']=$_GET["id"];
    $_SESSION['selectedVolDeparture']=$result[0]['departuretime'];
    $_SESSION['selectedVolArrival']=$result[0]['arrivaltime'];
    $_SESSION['selectedVolDate']=$_SESSION['departDate'];

    header("Location: confirmationVol.php");

}
function displayFlight(){

    $unixTimestamp = strtotime($_SESSION['selectedVolDate']);
    $daypropre = date("d/m/Y", $unixTimestamp);

    echo '<div class="card">';
    echo '<h5 class="card-header"> Vol #' . $_SESSION['selectedVolId'] . '</h5>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title"><i class="fa fa-plane"></i> &nbsp;' . $_SESSION['selectedVolDeparture'] . ' - ' . $_SESSION['selectedVolArrival'] . '</h5>';
    echo '<p class="card-text">' . $_SESSION['origincity'] . ' ('.$_SESSION['originAirport']. ') à ' . $_SESSION['destinationcity'] . ' ('.$_SESSION['destinationAirport'].')'.'<br>le '.$daypropre.'</p>';
    echo '<hr>';
    echo '<h5 class="card-text">Price €</h5>';
    echo '</div>';
    echo '</div><br>';

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
//    $route=" YEG-YQB";
    $unixTimestamp = strtotime($date);
    $dayOfWeek = date("w", $unixTimestamp); //dayoftime
    $daypropre = date("d/m/Y", $unixTimestamp);

    $nbr_Flight=0;

    $query = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
    $result = $db->prepare($query);
    $result->execute();
    $res = $result->fetchAll();
    foreach ($res as $data){
        $nbr_Flight++;

    }
    $origincity="";
    $destinationcity="";

    $query = "SELECT origincity, destinationcity FROM flights WHERE route ='".$route."'";
    $origin = $db->query($query);
    foreach ($origin as $data) {
        $origincity = $data['origincity'];
        $destinationcity = $data['destinationcity'];
        $_SESSION['origincity'] = $origincity;
        $_SESSION['destinationcity'] = $destinationcity;
    }

    if($nbr_Flight>=1) {
//        echo'<table class="table">
//        <thead>
//            <tr>
//                <th scope="col">#</th>
//                <th scope="col">ID</th>
//                <th scope="col">Route</th>
//                <th scope="col">Distance</th>
//                <th scope="col">Depart Time</th>
//                <th scope="col">Arrival time</th>
//                <th scope="col"></th>
//            </tr>
//        </thead>
//        <tbody>';
        $query1 = "SELECT id, route, distancekm, departuretime, arrivaltime FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
        $sth = $db->prepare($query1);
        $sth->execute();
        $result=$sth->fetchAll();

        for ($k = 0; $k < $nbr_Flight; $k++) {
            $index=$k+1;
            echo '<div class="card">';
            echo '<h5 class="card-header"> Vol #' . $result[$k]['id'] . '</h5>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><i class="fa fa-plane"></i> &nbsp;' . $result[$k]['departuretime'] . ' - ' . $result[$k]['arrivaltime'] . '</h5>';
            echo '<p class="card-text">' . $origincity . ' ('.$_SESSION['originAirport']. ') à ' . $destinationcity . ' ('.$_SESSION['destinationAirport'].')'.'<br>le '.$daypropre.'</p>';
            echo '<hr>';
            echo '<h5 class="card-text">Price €</h5>'; //Gérer le prix du Billet
            echo '<form method="POST" action="controller.php?func=selectedFlight&id='.$result[$k]['id'].'"><button style="float: right; width: 30%" type="submit" class="btn btn-white">Select</button></form>';
            echo '</div>';
            echo '</div><br>';

//            echo '<tr>';
//            echo '<th id="idStudent" scope="row">'.$index.'</th>';
//            echo '<td>' . $result[$k]['id'] . '</td>';
//            echo '<td>' . $result[$k]['route'] . '</td>';
//            echo '<td>' . $result[$k]['distancekm'] . '</td>';
//            echo '<td>' . $result[$k]['departuretime'] . '</td>';
//            echo '<td>' . $result[$k]['arrivaltime'] . '</td>';
//            echo '<td><form method="POST" action="confirmationVol.php?id='.$result[$k]['id'].'"><button style="float: right" type="submit" class="btn btn-white">Select</button></form></td>';
//            echo '</tr>';
        }
//        echo '</tbody>';
//        echo '</table>';
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
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Adulte n°'.$id.'</div>
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
 <br>
 ';
}

function CreateFormEnfant($id){
    $today = getDate();
    $todayYear = $today['year'];
    $todayMonth = $today['mon'];
    $todayDay = $today['mday'];
    $lastYear = $todayYear-4;
    echo ' 
<div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Enfant n°'.$id.'</div>
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
 <br>
 ';

}