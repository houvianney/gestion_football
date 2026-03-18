<?php

$host     = "localhost";
$utilisateur = "root";     
$motdepasse  = "";      
$base     = "gestion_projet"; 

$connexion = mysqli_connect($host, $utilisateur, $motdepasse, $base);

if (!$connexion) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

mysqli_set_charset($connexion, "utf8");
?>