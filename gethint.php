<?php

require_once 'connexpdo.php';

$dsn = 'pgsql:host=localhost;port=5432;dbname=avion;';
$user = 'postgres';
$password = 'new_password';
$db = connexpdo($dsn, $user, $password);


$a = array();
$query = "SELECT airportcode FROM taxes ORDER BY city";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
foreach ($res as $data){
    array_push($a, $data[0]);
}

$q = "";
$hint = "";

if ($q == "") {
    foreach ($a as $name) {
        $hint .= ",$name";
    }
}
echo $hint;


?>