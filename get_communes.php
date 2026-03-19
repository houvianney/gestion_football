<?php
include "connexion.php";

$id_depart = intval($_GET['id_depart']);

$sql = "SELECT id_Commune, lib_Commune FROM commune WHERE id_depart = $id_depart ORDER BY lib_Commune";

$result = mysqli_query($connexion, $sql);

$communes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $communes[] = $row;
}

echo json_encode($communes);

mysqli_close($connexion);
?>