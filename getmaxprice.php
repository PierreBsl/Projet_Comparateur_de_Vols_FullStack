<?php

require_once 'connexpdo.php';
require_once "controller.php";

global $db;
$q = $_REQUEST["q"];
$depart = $_SESSION['originAirport'];
$arrivee = $_SESSION['destinationAirport'];
$date = $_SESSION['departDate'];

/*
if($q == "+1"){
    $date4 = new DateTime($date);
    $date4->add(new DateInterval('P1D'));
    $date5= $date4->format('Y-m-d');

    $_SESSION['departDate']=$date5;
}
if($q == "-1"){
    $date6 = new DateTime($date);
    $date6->sub(new DateInterval('P1D'));
    $date7= $date6->format('Y-m-d');

    $_SESSION['departDate']=$date7;
}*/

$nbrAdults = $_SESSION['nbrAdultes'];
$nbrEnfants = $_SESSION['nbrEnfants'];
$nbPlace=$nbrAdults+$nbrEnfants;

$todaydate=date('Y-m-d');
$date1 = new DateTime($date);
$date2= new DateTime($todaydate);
$diffDate=$date1->diff($date2);
$d = $diffDate->format('%a');
$week = 0;
if ($d <= 7){
    $week=0;
}
else if ($d <= 14){
    $week=1;
}
else if ($d <= 21){
    $week=2;
}
else if ($d <= 28){
    $week=3;
}
else if ($d <= 35){
    $week=4;
}

$_SESSION['week']=$week;

$route = " ".$depart."-".$arrivee;
$unixTimestamp = strtotime($date);
$dayOfWeek = date("w", $unixTimestamp); //dayoftime
$_SESSION['dayOfWeek'] = $dayOfWeek;
$daypropre = date("d/m/Y", $unixTimestamp);


$nbrflights = 0;

$query = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND (flightsize >='".$nbPlace."'AND week = '".$week."'))";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
foreach ($res as $data){
    $nbrflights++;
}
$minimum = 5000;
$maximum = 0;

$query1 = "SELECT id FROM flights WHERE route ='".$route."' AND (dayofweek ='".$dayOfWeek."' AND (flightsize >='".$nbPlace."'AND week = '".$week."'))";
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
if($nbrflights == 1 ){
    $minimum=0;
}


$tab=[];

$tab['maxprice']=$maximum;
$tab['minprice']=0;
echo json_encode($tab);


?>