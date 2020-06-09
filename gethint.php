<?php

require_once 'connexpdo.php';

$dsn = 'pgsql:host=localhost;port=5432;dbname=avion;';
$user = 'postgres';
$password = 'new_password';
$db = connexpdo($dsn, $user, $password);


$a = array();
$tab = [];
$query = "SELECT originairport, origincity FROM flights ORDER BY origincity";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
$compteur=0;

foreach ($res as $data){
    if ($compteur > 0 && $tab["ville"][$compteur-1] == trim($data[1]))
    {
        $compteur--;
    }
    $tab["code"][$compteur] =trim($data[0]);
    $tab["ville"][$compteur]=trim($data[1]);
    $compteur++;

}
//$tab["code"] = array_unique($tab["code"]);
//$tab["ville"] = array_unique($tab["ville"]);
$q = "";
$hint = "";

if ($q == "") {
    foreach ($a as $name) {
        if ($hint == "")
        {
            $hint = "$name";
        }else{
            $hint .= ",$name";
        }

    }
}
echo json_encode($tab);
//echo $tab;


?>