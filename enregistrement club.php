<?php
// enregistrement_club.php — Question 4b
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulaire club.php");
    exit;
}

$nom_Club  = trim(mysqli_real_escape_string($connexion, $_POST['nom_Club']));
$id_Commune = intval($_POST['id_Commune']);

if (empty($nom_Club) || $id_Commune <= 0) {
    header("Location: formulaire club.php?statut=erreur&msg=Tous+les+champs+sont+obligatoires.");
    exit;
}

$sql = "INSERT INTO club (nom_Club, id_Commune) VALUES ('$nom_Club', $id_Commune)";

if (mysqli_query($connexion, $sql)) {
    header("Location: formulaire club.php?statut=ok");
} else {
    $erreur = urlencode(mysqli_error($connexion));
    header("Location: formulaire club.php?statut=erreur&msg=$erreur");
}

mysqli_close($connexion);
exit;
?>