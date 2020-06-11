<?php

require_once 'connexpdo.php';
require_once "controller.php";

global  $db;

$depart = $_SESSION['originAirport'];
$arrivee = $_SESSION['destinationAirport'];

$coordonate = [];

$query = "SELECT longitude, latitude FROM ville WHERE code = ' ".$depart."'";
$origin = $db->query($query);
foreach ($origin as $data) {
    $longitude = $data['longitude'];
    $latitude = $data['latitude'];
    $coordonate[0]['long']=$longitude;
    $coordonate[0]['lat']=$latitude;
}
$query = "SELECT longitude, latitude FROM ville WHERE code = ' ".$arrivee."'";
$origin = $db->query($query);
foreach ($origin as $data) {
    $longitude = $data['longitude'];
    $latitude = $data['latitude'];
    $coordonate[1]['long']=$longitude;
    $coordonate[1]['lat']=$latitude;
}


echo json_encode($coordonate);



?>