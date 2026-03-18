<?php
include "connexion.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des projets</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
 <?php include('menu.php'); ?>

<?php

if (isset($_GET['statut'])) {
    if ($_GET['statut'] === 'ok') {
        echo '<p class="message-success">&#10003; Projet enregistré avec succès.</p>';
    } elseif ($_GET['statut'] === 'erreur') {
        $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "Erreur inconnue.";
        echo '<p class="message-error">&#10007; Erreur : ' . $msg . '</p>';
    }
}
?>


<div class="form-container">
    <h2>Saisie des projets</h2>

    <form action="enregistrement.php" method="POST">

        <div class="form-row">
            <label for="codeProjet">Code projet</label>
            <input type="text" id="codeProjet" name="codeProjet"
                   placeholder="xxxxxx" maxlength="10" required>
        </div>

        <div class="form-row">
            <label for="nomProjet">Nom du projet</label>
            <input type="text" id="nomProjet" name="nomProjet"
                   placeholder="xxxxxx" required>
        </div>

        <div class="form-row">
            <label for="dateLancement">Date de lancement</label>
            <input type="date" id="dateLancement" name="dateLancement" required>
        </div>

        <div class="form-row">
            <label for="duree">Durée</label>
            <input type="number" id="duree" name="duree"
                   placeholder="xxxxxx" min="1" required>
        </div>

        <div class="form-row">
            <label for="codLocalite">Localité</label>
            <select id="codLocalite" name="codLocalite" required>
                <option value="">-- Choisir --</option>
                <?php
                
                $sql = "SELECT codLocalite, nomLocalite FROM Localite ORDER BY nomLocalite";
                $result = mysqli_query($connexion, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['codLocalite']) . '">'
                           . htmlspecialchars($row['nomLocalite']) . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>Aucune localité trouvée</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Soumettre</button>
            <button type="reset"  class="btn-cancel">Annuler</button>
        </div>

    </form>
</div>

</body>
</html>