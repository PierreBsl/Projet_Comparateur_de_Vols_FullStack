<?php

function connexpdo($base, $user, $password){
    try {
        return new PDO($base, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
}

$dsn = 'pgsql:host=localhost;port=5433;dbname=avion;';
$user = 'postgres';
$password = 'new_password';
$db = connexpdo($dsn, $user, $password);

?>