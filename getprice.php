<?php
require_once 'connexpdo.php';
require_once "controller.php";

global  $db;
$depart = $_SESSION['originAirport'];
$arrivee = $_SESSION['destinationAirport'];
$date = $_SESSION['departDate'];
$nbrAdults = $_SESSION['nbrAdultes'];
$nbrEnfants = $_SESSION['nbrEnfants'];
$volDirect = $_SESSION['volDirectCheck'];


$nbPlace=$nbrAdults+$nbrEnfants;
$route = " ".$depart."-".$arrivee;
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


$query = "SELECT city FROM ville WHERE code = ' ".$depart."'";
$origin = $db->query($query);
foreach ($origin as $data) {
    $origincity = $data['city'];
    $_SESSION['origincity'] = $origincity;
}
$query = "SELECT city FROM ville WHERE code = ' ".$arrivee."'";
$origin = $db->query($query);
foreach ($origin as $data) {
    $destinationcity = $data['city'];
    $_SESSION['destinationcity'] = $destinationcity;
}

$query1 = "SELECT id, route, distancekm, departuretime, arrivaltime FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
$sth = $db->prepare($query1);
$sth->execute();
$result=$sth->fetchAll();

$tab=$result;

for ($k = 0; $k < $nbr_Flight; $k++) {
    $tab[$k]['capacity'] =flightCapacity($result[$k]['id']);
    $tab[$k]['price'] = getPrice($result[$k]['id'], isWeekEnd(), dateDiff(), getRemplissage(flightCapacity($result[$k]['id'])));
    $tab[$k]['travelTime'] = travelTime($result[$k]['id']);
    $tab[$k]['origincity']=$origincity;
    $tab[$k]['destinationcity'] = $destinationcity;
    $tab[$k]['sessionOP'] = $_SESSION['originAirport'];
    $tab[$k]['sessionDP'] = $_SESSION['destinationAirport'];
    $tab[$k]['daypropre'] = $daypropre;
}



echo json_encode($tab);


?>