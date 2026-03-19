<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulaire.php");
    exit;
}

$lib_Commune   = trim(mysqli_real_escape_string($connexion, $_POST['lib_Commune']));
$id_depart  = trim(mysqli_real_escape_string($connexion, $_POST['id_depart']));


if (empty($lib_Commune) || empty($id_depart)) {
    header("Location: formulaire.php?statut=erreur&msg=Tous+les+champs+sont+obligatoires.");
    exit;
}
        
// $verifSql = "SELECT codeProjet FROM Projet WHERE codeProjet = '$codeProjet'";
// $verifResult = mysqli_query($connexion, $verifSql);

// if (mysqli_num_rows($verifResult) > 0) {
//     header("Location: formulaire.php?statut=erreur&msg=Ce+code+projet+existe+déjà.");
//     exit;
// }

$sql = "INSERT INTO commune (lib_Commune, id_depart)
        VALUES ('$lib_Commune', '$id_depart')";

if (mysqli_query($connexion, $sql)) {
    header("Location: formulaire.php?statut=ok");
} else {
    $erreur = urlencode(mysqli_error($connexion));
    header("Location: formulaire.php?statut=erreur&msg=$erreur");
}

mysqli_close($connexion);
exit;
?>