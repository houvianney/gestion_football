<?php
// supprimer_joueur.php
include "connexion.php";

if (!isset($_GET['id'])) {
    header("location: gestion_joueurs.php");
    exit;
}

$id      = intval($_GET['id']);
$requete = "DELETE FROM joueur WHERE id_Joueur = $id";

if (mysqli_query($connexion, $requete) && mysqli_affected_rows($connexion) > 0) {
    header("location: gestion_joueurs.php?success=suppr");
} else {
    header("location: gestion_joueurs.php?error=4");
}

mysqli_close($connexion);
exit;
?>