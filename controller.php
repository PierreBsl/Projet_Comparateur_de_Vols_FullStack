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
    echo '<div class="row" >';
    echo '<div class="col">';
    echo '<p class="card-text">' . $_SESSION['origincity'] . ' ('.$_SESSION['originAirport']. ') à ' . $_SESSION['destinationcity'] . ' ('.$_SESSION['destinationAirport'].')'.'<br>le '.$daypropre.'</p>';
    echo '</div>';
    echo '<div class="col">';
    echo '<p class="card-text">' . $_SESSION['origincity'] . ' ('.$_SESSION['originAirport']. ') à ' . $_SESSION['destinationcity'] . ' ('.$_SESSION['destinationAirport'].')'.'<br>le '.$daypropre.'</p>';
    echo '</div></div>';
    echo '<hr>';
    echo '<h5 class="card-text">Price 150€</h5>';
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
    $_SESSION['dayOfWeek'] = $dayOfWeek;
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

    $query1 = "SELECT id, route, distancekm, departuretime, arrivaltime FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
    $sth = $db->prepare($query1);
    $sth->execute();
    $result=$sth->fetchAll();
    $query2 = "SELECT fillingrate, farecode, weflights, departuretime, arrivaltime FROM companyprices WHERE route ='".$route."' ";
    $sth1 = $db->prepare($query2);
    $sth1->execute();
    $result1=$sth->fetchAll();

    for ($k = 0; $k < $nbr_Flight; $k++) {
        $index=$k+1;
        echo '<div class="card">';
        echo '<h5 class="card-header"> Vol #' . $result[$k]['id'] . '</h5>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title"><i class="fa fa-plane"></i> &nbsp;' . $result[$k]['departuretime'] . ' - ' . $result[$k]['arrivaltime'] . '</h5>';
        echo '<div class="row" >';
        echo '<div class="col">';
        echo '<p class="card-text"><i class="fa fa-map-marker"></i> ' . $origincity . ' ('.$_SESSION['originAirport']. ') à ' .
            $destinationcity . ' ('.$_SESSION['destinationAirport'].')'.'<br><i class="fa fa-calendar"></i> '.$daypropre.'</p>';
        echo '</div>';
        echo '<div class="col">';
        echo '<p class="card-text">Durée du voyage <br><i class="fa fa-clock-o" ></i>'.travelTime($result[$k]['id']);
        echo '</div>';
        echo '<div class="col">';
        echo '<p class="card-text">Places Restantes <br> <div class="progress">';
        echo '<div id="progress-bar" class="progress-bar bg-white" style="width:'.flightCapacity($result[$k]['id']).'%;color:white; background-color:orangered !important;" aria-valuemin="0" aria-valuemax="100">'.flightCapacity($result[$k]['id']).' %</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
        echo '<h5 class="card-text">À partir de 150€</h5>';
        echo '<form method="POST" action="controller.php?func=selectedFlight&id='.$result[$k]['id'].'"><button style="float: right; width: 30%" type="submit" class="btn btn-outline-white">Select</button></form>';
        echo '</div>';
        echo '</div><br>';
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
function dateDiff(){
    $today = date_create(getdate());
    $date = date_create($_SESSION['dayOfWeek']);
    $interval = date_diff($date, $today, true);
    return (int) $interval->format('%d');
}

function travelTime($id){
    global $db;
    $query = "SELECT departureTime, arrivalTime FROM flights WHERE id ='".$id."'";
    $sth = $db->prepare($query);
    $sth->execute();
    $result = $sth->fetch();
    $datetime1 = new DateTime($result[0]);
    $datetime2 = new DateTime($result[1]);
    $interval = $datetime1->diff($datetime2);
    return $interval->format(' %hh%i ');
}

function flightCapacity($id){
    global $db;
    $query = "SELECT flightsize, flightcapacity FROM flights WHERE id ='".$id."'";
    $sth = $db->prepare($query);
    $sth->execute();
    $result = $sth->fetch();
    $places_restantes = $result[1]/$result[0]*100;
    return $places_restantes;
}

function isWeekEnd(){
    if($_SESSION['dayOfWeek'] == 0 || $_SESSION['dayOfWeek'] == 6) {
        return true;
    }
    else return false;
}