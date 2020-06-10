<?php

require_once 'connexpdo.php';

$dsn = 'pgsql:host=localhost;port=5433;dbname=avion;';
$user = 'postgres';
$password = 'new_password';
$db = connexpdo($dsn, $user, $password);


$a = array();
$tab = [];
$query = "SELECT code, city FROM ville ORDER BY city ";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
$compteur=0;

foreach ($res as $data){
    $tab["code"][$compteur] =trim($data[0]);
    $tab["ville"][$compteur]=trim($data[1]);
    $compteur++;

}
//$tab["code"] = array_unique($tab["code"]);
//$tab["ville"] = array_unique($tab["ville"]);

echo json_encode($tab);


?>