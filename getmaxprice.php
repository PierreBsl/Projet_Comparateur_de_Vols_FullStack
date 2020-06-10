<?php

require_once 'connexpdo.php';
require_once "controller.php";

global $db;

$depart = $_SESSION['originAirport'];
$arrivee = $_SESSION['destinationAirport'];
$date = $_SESSION['departDate'];
$nbrAdults = $_SESSION['nbrAdultes'];
$nbrEnfants = $_SESSION['nbrEnfants'];
$nbPlace=$nbrAdults+$nbrEnfants;


$route = " ".$depart."-".$arrivee;
$unixTimestamp = strtotime($date);
$dayOfWeek = date("w", $unixTimestamp); //dayoftime

$nbrflights = 0;

$query = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
foreach ($res as $data){
    $nbrflights++;
}
$minimum = 5000;
$maximum = 0;

$query1 = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND flightsize >='".$nbPlace."')";
$sth = $db->prepare($query1);
$sth->execute();
$result=$sth->fetchAll();
for ($k = 0; $k < $nbrflights; $k++) {
    $price = getPrice($result[$k]['id'], isWeekEnd(),dateDiff(), getRemplissage(flightCapacity($result[$k]['id'])));
    if ( $price > $maximum){
        $maximum = $price;
    }
    else if ($price < $minimum){
        $minimum = $price;
    }
}

$tab=[];

$tab['maxprice']=$maximum;
$tab['minprice']=0;
echo json_encode($tab);


?>