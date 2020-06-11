<?php

require_once 'connexpdo.php';

global $db;

$tab = [];
$query = "SELECT code, city FROM ville ORDER BY city";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
$compteur=0;

foreach ($res as $data){
    $tab["code"][$compteur] =trim($data[0]);
    $tab["ville"][$compteur]=trim($data[1]);
    $compteur++;

}
$tab2=$tab;
echo json_encode($tab);



?>