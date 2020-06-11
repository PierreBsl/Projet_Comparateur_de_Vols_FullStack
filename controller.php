<?php

require_once 'connexpdo.php';

session_start();

if (isset($_GET["func"]))
{

    if ($_GET["func"] == "deletePeople"){
        deletePeople($_GET['id']);
    }
    if ($_GET["func"]=="readFlights"){
        redirectFlights($_POST['originAirport'], $_POST['destinationAirport'], $_POST['departDate'], $_POST['nbrAdultes'], $_POST['nbrEnfants'], $_POST['volDirectCheck']);
        $_SESSION['active'] = 1;
    }
    if ($_GET["func"]=="selectedFlight"){
        selectedFlight($_GET['id'], $_GET['price'], $_GET['capacity'], $_GET['travelTime']);
        $_SESSION['active'] = 2;
    }
    if ($_GET["func"]=="createUser"){
        $numeroCommande = rand(1000,999999);
        $_SESSION['commande'] = $numeroCommande;

        for ($i=0; $i<$_SESSION['nbrAdultes']; $i++){
            $k =$i+1;
            createAdult($_POST['nomAdult'.$k], $_POST['prenomAdult'.$k], $_POST['emailAdult'.$k], $_POST['birthAdult'.$k], 1, $_SESSION['price']);
        }
        for ($i=0; $i<$_SESSION['nbrEnfants']; $i++){
            $k =$i+1;
            $childrenPrice = $_SESSION['price']/2;
            createChildren($_POST['nomEnfant'.$k], $_POST['prenomEnfant'.$k], $_POST['birthEnfant'.$k], 0, $childrenPrice);
        }
        $_SESSION['active'] = 3;
        header( "Location:confirmationVol.php");
    }
    if ($_GET["func"]=="confirmUser"){

        for ($i=0; $i<$_SESSION['nbrAdultes']; $i++){
            confirmAdult();
        }
        for ($i=0; $i<$_SESSION['nbrEnfants']; $i++){
            confirmChildren();
        }
        deleteReservation();
        header( "Location:index.php?error=confirm");
    }
    if ($_GET["func"]=="deleteReservation"){
        deleteReservation();
    }

}

function deleteReservation(){
    global $db;

    $query = "DELETE FROM commande ";
    $sth = $db->prepare($query);
    $sth->execute();

    header( "Location:index.php?error=cancelled");
}

function confirmAdult(){

    global  $db;

    $query = "SELECT nom, prenom, mail, birth, adult, depense, idreservation FROM commande WHERE idcommande ='".$_SESSION['commande']."' AND adult = 1";
    $result = $db->prepare($query);
    $result->execute();
    $res = $result->fetchAll();
    foreach ($res as $data){
        $nomA = $data['nom'];
        $prenomA = $data['prenom'];
        $mailA = $data['mail'];
        $birthDateA = $data['birth'];
        $isAdultA = $data['adult'];
        $depenseA = $data['depense'];
    }

    $sql1 = "INSERT INTO users (idcommande, nom, prenom, mail, birth, adult, depense, idreservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sqlR1 = $db->prepare($sql1);
    $sqlR1->execute([$_SESSION['commande'], $nomA, $prenomA, $mailA, $birthDateA, $isAdultA, $depenseA, $_SESSION['selectedVolId']]);

    $sql = "UPDATE flights SET flightcapacity = flightcapacity - 1 WHERE id='".$_SESSION['selectedVolId']."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

}

function confirmChildren(){

    global  $db;

    $query = "SELECT nom, prenom, mail, birth, adult, depense, idreservation FROM commande WHERE idcommande ='".$_SESSION['commande']."' AND adult = 0";
    $result = $db->prepare($query);
    $result->execute();
    $res = $result->fetchAll();
    foreach ($res as $data){
        $nomC = $data['nom'];
        $prenomC = $data['prenom'];
        $birthDateC = $data['birth'];
        $isAdultC = $data['adult'];
        $depenseC = $data['depense'];
    }

    $sql1 = "INSERT INTO users (idcommande, nom, prenom, mail, birth, adult, depense, idreservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sqlR1 = $db->prepare($sql1);
    $sqlR1->execute([$_SESSION['commande'], $nomC, $prenomC, '', $birthDateC, $isAdultC, $depenseC, $_SESSION['selectedVolId']]);

    $sql = "UPDATE flights SET flightcapacity = flightcapacity - 1 WHERE id='".$_SESSION['selectedVolId']."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

}

function createAdult($nom, $prenom, $mail, $birthDate, $isAdult, $depense){

    global  $db;

    $sql1 = "INSERT INTO commande (idcommande, nom, prenom, mail, birth, adult, depense, idReservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sqlR1 = $db->prepare($sql1);
    $sqlR1->execute([$_SESSION['commande'], $nom, $prenom, $mail, $birthDate, $isAdult, $depense, $_SESSION['selectedVolId']]);

}

function createChildren($nom, $prenom, $birthDate, $isAdult, $depense){

    global  $db;

    $sql1 = "INSERT INTO commande (idcommande, nom, prenom, mail, birth, adult, depense, idreservation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sqlR1 = $db->prepare($sql1);
    $sqlR1->execute([$_SESSION['commande'], $nom, $prenom, '', $birthDate, $isAdult, $depense, $_SESSION['selectedVolId']]);

}

function ConnectUser($mail, $birth) {
    global  $db;

    $q = "SELECT id FROM users WHERE mail = '".$mail."' AND  birth = '".$birth."'";
    $sth = $db->prepare($q);
    $sth->execute();
    $r = $sth->fetch();

    if ($r[0]) {
        $_SESSION["userId"] = $r[0];
    } else {
        header("Location:index.php");
    }
}

function selectedFlight($idVol, $price, $capacity, $travelTime){
    global  $db;

    $query1 = "SELECT route, distancekm, departuretime, arrivaltime FROM flights WHERE id ='".$idVol."'";
    $sth = $db->prepare($query1);
    $sth->execute();
    $result=$sth->fetchAll();

    $_SESSION['selectedVolId'] = $idVol;
    $_SESSION['selectedVolDeparture'] = $result[0]['departuretime'];
    $_SESSION['selectedVolArrival'] = $result[0]['arrivaltime'];
    $_SESSION['selectedVolDate'] = $_SESSION['departDate'];
    $_SESSION['price'] = $price;
    $_SESSION['$capacity'] = $capacity;
    $_SESSION['travelTime'] = $travelTime;

    header("Location: confirmationVol.php");

}

function displayCommande(){
    $unixTimestamp = strtotime($_SESSION['selectedVolDate']);
    $daypropre = date("d/m/Y", $unixTimestamp);

    echo '<div class="card">';
    echo '<h5 class="card-header"> Vol #' . $_SESSION['selectedVolId'] . '</h5>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title"><i class="fa fa-plane"></i> &nbsp;' . $_SESSION['selectedVolDeparture'] . ' - ' . $_SESSION['selectedVolArrival'] . '</h5>';
    echo '<div class="row" >';
    echo '<div class="col">';
    echo '<p class="card-text"><i class="fa fa-map-marker"></i> &nbsp;' . $_SESSION['origincity'] . ' ('.$_SESSION['originAirport']. ') à ' . $_SESSION['destinationcity'] . ' ('.$_SESSION['destinationAirport'].')'.'<br><i class="fa fa-calendar"></i> '.$daypropre.'</p>';
    echo '</div>';
    echo '<div class="col">';
    echo '<p class="card-text">Durée du voyage <br><i class="fa fa-clock-o" ></i> '.$_SESSION['travelTime'];
    echo '</div>';
    echo '<div class="col">';
    echo '<p class="card-text">Capacité Restante <br> <div class="progress">';
    echo '<div id="progress-bar" class="progress-bar bg-white" style="width:'.$_SESSION['$capacity'].'%;color:white; background-color:orangered !important;" aria-valuemin="0" aria-valuemax="100">'.$_SESSION['$capacity'].' %</div>';
    echo '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card-footer">';
    echo '<div class="row">';
    echo '<div class="col">';
    echo '<p class="card-text">- ' . $_SESSION['nbrAdultes'] . ' x Adulte(s) &nbsp; : &nbsp; ' . $_SESSION['price'] . '€</p>';
    $enfantPrice = $_SESSION['price'] / 2;
    echo '<p class="card-text">- ' . $_SESSION['nbrEnfants'] . ' x Enfant(s) &nbsp; : &nbsp; ' . $enfantPrice . '€';
    echo '</div>';
    echo '<div class="col">';
    echo '<h5 class="card-text" style="padding-top: 17%; float: right">Prix Total ' . getTotPrice() . '€</h5>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div><br>';
    echo '<form method="POST" action="controller.php?func=confirmUser"><button style="width: 100%" type="submit" class="btn btn-white">Valider la commande</button></form><br>';
    echo '<form method="POST" action="controller.php?func=deleteReservation"><button style="width: 100%" type="submit" class="btn btn-white">Annuler la commande</button></form>';


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
    echo '<p class="card-text"><i class="fa fa-map-marker"></i> ' . $_SESSION['origincity'] . ' ('.$_SESSION['originAirport']. ') à ' . $_SESSION['destinationcity'] . ' ('.$_SESSION['destinationAirport'].')'.'<br><i class="fa fa-calendar"></i> '.$daypropre.'</p>';
    echo '</div>';
    echo '<div class="col">';
    echo '<p class="card-text">Durée du voyage <br><i class="fa fa-clock-o" ></i> &nbsp;'.$_SESSION['travelTime'];
    echo '</div>';
    echo '<div class="col">';
    echo '<p class="card-text">Capacité Restante <br>';
    echo '<div id="progress-bar" class="progress-bar bg-white" style="width:'.$_SESSION['$capacity'].'%;color:white; background-color:orangered !important;" aria-valuemin="0" aria-valuemax="100">'.$_SESSION['$capacity'].' %</div>';
    echo '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div><br>';
}

function redirectFlights($depart, $arrivee, $date, $nbrAdults, $nbrEnfants, $volDirect){
    global  $db;
    $query2 = "SELECT city FROM  ville WHERE code = ' ".$depart."'";
    $result2 = $db->prepare($query2);
    $result2->execute();
    $res2 = $result2->fetchAll();

    $query3 = "SELECT city FROM  ville WHERE code = ' ".$arrivee."'";
    $result3 = $db->prepare($query3);
    $result3->execute();
    $res3 = $result3->fetchAll();

    if(!isset($res2[0][0])){
        header("Location: index.php?error=villedepart");
    }else if(!isset($res3[0][0])){
        header("Location: index.php?error=villearrivee");
    }else{
        header("Location: affichageVol.php");
    }



    $_SESSION['originAirport']=$depart;
    $_SESSION['destinationAirport']=$arrivee;
    $_SESSION['departDate']=$date;
    $_SESSION['nbrAdultes']=$nbrAdults;
    $_SESSION['nbrEnfants']=$nbrEnfants;
    $_SESSION['volDirectCheck']=$volDirect;

}

function CreateFormAdult($id){
    $year = date("Y");
    $year1 = $year-4;
    $year2 = $year - 130;
    $date = date ($year1."-m-d");
    $actualDate = date($year2."-m-d");

    echo '
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Adulte n°'.$id.'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomAdult'.$id.'" placeholder="Nom" required>
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomAdult'.$id.'" placeholder="Prénom" required>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                            Adresse e-mail
                            <input type="email" class="form-control" name="emailAdult'.$id.'" placeholder="Adresse e-mail" required>
                        </div>
                        <div class="form-group col-md-6">
                          Date de Naissance
                          <input type="date" class="form-control" min="'.$actualDate.'" max="'.$date.'" name="birthAdult'.$id.'" required>
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
    $year = date("Y");
    $year = $year-4;
    $date = date($year."-m-d");
    $actualDate = date("Y-m-d");

    echo '
<div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Enfant n°'.$id.'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        Nom
                        <input type="text" class="form-control" name="nomEnfant'.$id.'" placeholder="Nom" required>
                    </div>
                    <div class="form-group col-md-6">
                      Prénom
                      <input type="text" class="form-control" name="prenomEnfant'.$id.'" placeholder="Prénom" required>
                    </div>
                </div>
                <div class="form-group">
                      Date de Naissance
                      <input type="date" class="form-control" min="'.$date.'" max="'.$actualDate.'" name="birthEnfant'.$id.'" required>
                </div>
            </div>
        </div>
    </div>
 </div>
 <br>
 ';
}

function dateDiff(){
    $today = getdate();
    $today = $today['mday'];
    $_SESSION['departDate'];
    $weekDay1 = $_SESSION['departDate'][8].$_SESSION['departDate'][9];
    $diff=$weekDay1-$today;
    if($diff > 21){
        return 21;
    } if ($diff > 10){
        return 10;
    } if ($diff > 3){
        return 3;
    } else {
        return 0;
    }
}

function travelTime($id){
    global $db;
    $query = "SELECT departureTime, arrivalTime FROM flights WHERE id ='".$id."'";
    $sth = $db->prepare($query);
    $sth->execute();
    $result = $sth->fetch();
    $datetime1 = new DateTime($result[0]);
    $datetime2 = new DateTime($result[1]);

    $datetime1 = strval($datetime1->format('H:i:s'));
    $datetime2 = strval($datetime2->format('H:i:s'));
    $timestamp1 = date_create_from_format("H:i:s", $datetime1);
    $timestamp2 = date_create_from_format("H:i:s", $datetime2);
    if($timestamp2 < $timestamp1){
        $interval = date_diff(date_add($timestamp2, DateInterval::createFromDateString("24 hours")), $timestamp1);
    }
    else {
        $interval = date_diff($timestamp2, $timestamp1);
    }
    return $interval->format("%Hh%Imin");
}

function flightCapacity($id){
    global $db;
    $query = "SELECT flightsize, flightcapacity FROM flights WHERE id ='".$id."'";
    $sth = $db->prepare($query);
    $sth->execute();
    $result = $sth->fetch();
    $places_restantes = $result[1] / $result[0] * 100;
    return (int) $places_restantes;
}

function isWeekEnd(){
    if($_SESSION['dayOfWeek'] == 0 || $_SESSION['dayOfWeek'] == 6) {
        return 1;
    }
    else return 0;
}

function displayCardByAdult(){
    global  $db;

    $q = "SELECT nom, prenom, mail, birth FROM commande WHERE idcommande = ".$_SESSION['commande']." AND adult = 1";
    $sth = $db->prepare($q);
    $sth->execute();
    $result = $sth->fetchAll();
    $nAdultes=0;

    for ($k = 0; $k < $_SESSION['nbrAdultes']; $k++) {
        $nAdultes = $nAdultes +1;
        $unixTimestamp = strtotime($result[$k]['birth']);
        $naissance = date("d F Y", $unixTimestamp);
        echo '
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Adulte n°'.$nAdultes.'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        '.$result[$k]['nom'].'&nbsp;'.$result[$k]['prenom'].'
                    </div>
                    <div class="form-group col-md-6">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        '.$result[$k]['mail'].'
                    </div>
                    <div class="form-group col-md-6">
                    <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        '.$naissance.'        
                    </div>
                </div>
            </div>
            <div class="card-footer">
            <h5>Prix du billet : '.$_SESSION['price'].'€</h5>
            </div>
        </div>
    </div>
 </div>
 <br>';
    }
}

function displayCardByChildren(){
    global  $db;

    $q = "SELECT nom, prenom, birth FROM commande WHERE idcommande = ".$_SESSION['commande']." AND adult = 0";
    $sth = $db->prepare($q);
    $sth->execute();
    $result = $sth->fetchAll();
    $nEnfants=0;

    for ($k = 0; $k < $_SESSION['nbrEnfants']; $k++) {
        $nEnfants = $nEnfants +1;
        $unixTimestamp = strtotime($result[$k]['birth']);
        $naissance = date("d F Y", $unixTimestamp);
        echo '
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Enfant n°'.$nEnfants.'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        '.$result[$k]['nom'].'&nbsp&nbsp;'.$result[$k]['prenom'].' 
                    </div>
                    <div class="form-group col-md-6">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        '.$naissance.'  
                    </div>
                    <div class="form-group col-md-6">
     
                    </div>
                </div>
            </div>
            <div class="card-footer">';
        $pChildren = $_SESSION['price']/2;
        echo '<h5>Prix du billet : '.$pChildren.'€</h5>
            </div>
        </div>
    </div>
 </div>
 <br>';
    }
}

function getPrice($id, $weFlight, $dateToDeparture, $remplissage){
    global $db;
    $query1 = "SELECT originairport, destinationairport, route FROM flights WHERE id = '".$id."'";
    $sth1 = $db->prepare($query1);
    $sth1->execute();
    $result1=$sth1->fetchAll();

    //print_r($result1[0][2]);
    //echo $result1[1];

    $result1[0][2] = trim($result1[0][2]);

    $query2 = "SELECT fare FROM companyPrices WHERE route ='".$result1[0][2]."' AND ( weFlights = ".$weFlight." AND dateToDeparture = ".$dateToDeparture.")";
    $sth2 = $db->prepare($query2);
    $sth2->execute();
    $result2 = $sth2->fetch();

    $query3 = "SELECT fare FROM companyPrices WHERE route ='".$result1[0][2]."' AND ( weFlights = ".$weFlight." AND fillingRate = ".$remplissage.")";
    $sth3 = $db->prepare($query3);
    $sth3->execute();
    $result3 = $sth3->fetch();

    if ($result2[0] > $result3[0]){
        $priceFly = $result2[0];
    } else {
        $priceFly = $result3[0];
    }

    $query4 = "SELECT surcharge FROM taxes WHERE airportCode = '".$result1[0][0]."'";
    $sth4 = $db->prepare($query4);
    $sth4->execute();
    $result4 = $sth4->fetch();

    $query5 = "SELECT surcharge FROM taxes WHERE airportCode = '".$result1[0][1]."'";
    $sth5 = $db->prepare($query5);
    $sth5->execute();
    $result5 = $sth5->fetch();
    $lel = $priceFly + $result4[0] + $result5[0];
    return $priceFly + $result4[0] + $result5[0];
}

function getTotPrice(){
    return $_SESSION["nbrEnfants"] * $_SESSION["price"] / 2 + $_SESSION["nbrAdultes"] * $_SESSION["price"];
}

function getRemplissage($capacteRestance){
    if($capacteRestance > 60){
        return 40;
    } if ($capacteRestance > 30){
        return 70;
    } if ($capacteRestance > 10){
        return 90;
    } else {
        return 100;
    }
}

function deletePeople($id){
    global $db;


    $query1 = "SELECT idReservation FROM users WHERE id = ".$id;
    $sth1 = $db->prepare($query1);
    $sth1->execute();
    $sth1->fetch();

    $sql = "UPDATE flights SET flightcapacity = flightcapacity - 1 WHERE id='".$_SESSION['selectedVolId']."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $query = "DELETE FROM users WHERE id = ".$id;
    $sth = $db->prepare($query);
    $sth->execute();

    header("location:affichageAdmin.php");
}

function affichageAdmin(){
    global $db;

    $query = "SELECT max(id) FROM users ";
    $sth = $db->prepare($query);
    $sth->execute();
    $result = $sth->fetch();



    for($i = 0; $i < $result[0] + 1; $i++){

        $query2 = "SELECT adult FROM users WHERE id = ".$i;
        $sth2 = $db->prepare($query2);
        $sth2->execute();
        $result2 = $sth2->fetch();

        if($result2[0]  === 0){  //C'est un enfant;
            adminDisplayEnfant($i);
        } else if($result2[0] == 1) {   //Adult
            adminDisplayAdult($i);
        }

    }
}

function adminDisplayAdult($id){
    global  $db;

    $q = "SELECT nom, prenom, mail, birth, idcommande, depense, idReservation FROM users WHERE id = ".$id;
    $sth = $db->prepare($q);
    $sth->execute();
    $result = $sth->fetchAll();

    echo '
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Code utilisateur : '.$result[0][4].' - Adulte - Vol n° : '.$result[0][6].'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        '.$result[0][0].'&nbsp;'.$result[0][1].'
                    </div>
                    <div class="form-group col-md-6">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        '.$result[0][2].'
                    </div>
                    <div class="form-group col-md-6">
                    <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        '.$result[0][3].'        
                    </div>
                </div>
            </div>
            <div class="card-footer">
            <h5>Prix total dépensé : '.$result[0][5].'€</h5>
             <form method="POST" action="controller.php?func=deletePeople&id='.$id.'"><button style="float: right; width: 30%" type="submit" class="btn btn-outline-white">Supprimer</button></form>
            </div>
        </div>
    </div>
 </div>
 <br>';
}

function adminDisplayEnfant($id){
    global  $db;

    $q = "SELECT nom, prenom, birth, idcommande, depense, idReservation FROM users WHERE id = ".$id;
    $sth = $db->prepare($q);
    $sth->execute();
    $result = $sth->fetchAll();
    echo '
 <div class="row">
    <div class="col col-mx-auto">
        <div class="card">
            <div class="card-header">Code utilisateur : '.$result[0][3].' - Enfant - Vol n° : '.$result[0][5].'</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        '.$result[0][0].'&nbsp;'.$result[0][1].'
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                        '.$result[0][2].'        
                    </div>
                </div>
            </div>
            <div class="card-footer">
            <h5>Prix total dépensé : '.$result[0][4].'€</h5>
            <form method="POST" action="controller.php?func=deletePeople&id='.$id.'"><button style="float: right; width: 30%" type="submit" class="btn btn-outline-white">Supprimer</button></form>
            </div>
        </div>
    </div>
 </div>
 <br>';
}