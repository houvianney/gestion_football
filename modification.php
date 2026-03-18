<?php

include "connexion.php";


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['code'])) {

    $code = trim(mysqli_real_escape_string($connexion, $_GET['code']));

    // Récupérer le projet à modifier
    $sql    = "SELECT * FROM Projet WHERE codeProjet = '$code'";
    $result = mysqli_query($connexion, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo '<p style="font-family:Arial;font-size:12px;color:red;">
              Projet introuvable pour le code : ' . htmlspecialchars($code) . '</p>';
        mysqli_close($connexion);
        exit;
    }

    $projet = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification d'un projet</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('menu.php'); ?>
<div class="form-container">
    

    <h2>Modification du projet</h2>

    <form action="modification.php" method="POST">

        
        <div class="form-row">
            <label>Code projet</label>
            <input type="text"
                   value="<?= htmlspecialchars($projet['codeProjet']) ?>"
                   readonly style="background:#eee;">
            <input type="hidden" name="codeProjet"
                   value="<?= htmlspecialchars($projet['codeProjet']) ?>">
        </div>

        <div class="form-row">
            <label for="nomProjet">Nom du projet</label>
            <input type="text" id="nomProjet" name="nomProjet"
                   value="<?= htmlspecialchars($projet['nomProjet']) ?>" required>
        </div>

        <div class="form-row">
            <label for="dateLancement">Date de lancement</label>
            <input type="date" id="dateLancement" name="dateLancement"
                   value="<?= htmlspecialchars($projet['dateLancement']) ?>" required>
        </div>

        <div class="form-row">
            <label for="duree">Durée</label>
            <input type="number" id="duree" name="duree"
                   value="<?= htmlspecialchars($projet['duree']) ?>"
                   min="1" required>
        </div>

        <div class="form-row">
            <label for="codLocalite">Localité</label>
            <select id="codLocalite" name="codLocalite" required>
                <?php
                $sqlLoc = "SELECT codLocalite, nomLocalite FROM Localite ORDER BY nomLocalite";
                $resLoc = mysqli_query($connexion, $sqlLoc);
                while ($loc = mysqli_fetch_assoc($resLoc)) {
                    $selected = ($loc['codLocalite'] == $projet['codLocalite']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($loc['codLocalite'])
                       . '" ' . $selected . '>'
                       . htmlspecialchars($loc['nomLocalite']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Enregistrer</button>
            <button type="button" class="btn-cancel"
                    onclick="window.location='formulaire.php'">Annuler</button>
        </div>

    </form>
</div>

</body>
</html>
<?php
    mysqli_close($connexion);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $codeProjet    = trim(mysqli_real_escape_string($connexion, $_POST['codeProjet']));
    $nomProjet     = trim(mysqli_real_escape_string($connexion, $_POST['nomProjet']));
    $dateLancement = trim(mysqli_real_escape_string($connexion, $_POST['dateLancement']));
    $duree         = intval($_POST['duree']);
    $codLocalite   = trim(mysqli_real_escape_string($connexion, $_POST['codLocalite']));

   
    $sqlUpdate = "UPDATE Projet
                  SET    nomProjet     = '$nomProjet',
                         dateLancement = '$dateLancement',
                         duree         = $duree,
                         codLocalite   = '$codLocalite'
                  WHERE  codeProjet    = '$codeProjet'";

    if (mysqli_query($connexion, $sqlUpdate)) {
        // Vérifie si une ligne a vraiment été modifiée
        if (mysqli_affected_rows($connexion) > 0) {
            header("Location: formulaire.php?statut=ok");
        } else {
            header("Location: formulaire.php?statut=erreur&msg=Aucune+modification+détectée.");
        }
    } else {
        $erreur = urlencode(mysqli_error($connexion));
        header("Location: formulaire.php?statut=erreur&msg=$erreur");
    }

    mysqli_close($connexion);
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un projet</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
 <?php include('menu.php'); ?>

<div class="form-container">
    <h2>Modifier un projet</h2>
    <form action="modification.php" method="GET">
        <div class="form-row">
            <label for="code">Code projet</label>
            <input type="text" id="code" name="code"
                   placeholder="Saisir le code" required>
        </div>
        <div class="form-buttons">
            <button type="submit" class="btn-submit">Rechercher</button>
        </div>
    </form>
</div>
</body>
</html>