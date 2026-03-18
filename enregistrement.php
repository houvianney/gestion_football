<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulaire.php");
    exit;
}

$codeProjet    = trim(mysqli_real_escape_string($connexion, $_POST['codeProjet']));
$nomProjet     = trim(mysqli_real_escape_string($connexion, $_POST['nomProjet']));
$dateLancement = trim(mysqli_real_escape_string($connexion, $_POST['dateLancement']));
$duree         = intval($_POST['duree']);
$codLocalite   = trim(mysqli_real_escape_string($connexion, $_POST['codLocalite']));

if (empty($codeProjet) || empty($nomProjet) || empty($dateLancement)
    || $duree <= 0 || empty($codLocalite)) {
    header("Location: formulaire.php?statut=erreur&msg=Tous+les+champs+sont+obligatoires.");
    exit;
}

$verifSql = "SELECT codeProjet FROM Projet WHERE codeProjet = '$codeProjet'";
$verifResult = mysqli_query($connexion, $verifSql);

if (mysqli_num_rows($verifResult) > 0) {
    header("Location: formulaire.php?statut=erreur&msg=Ce+code+projet+existe+déjà.");
    exit;
}

$sql = "INSERT INTO Projet (codeProjet, nomProjet, dateLancement, duree, codLocalite)
        VALUES ('$codeProjet', '$nomProjet', '$dateLancement', $duree, '$codLocalite')";

if (mysqli_query($connexion, $sql)) {
    header("Location: formulaire.php?statut=ok");
} else {
    $erreur = urlencode(mysqli_error($connexion));
    header("Location: formulaire.php?statut=erreur&msg=$erreur");
}

mysqli_close($connexion);
exit;
?>