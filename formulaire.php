<?php
include "connexion.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des communes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
 <?php include('menu.php'); ?>

<?php

if (isset($_GET['statut'])) {
    if ($_GET['statut'] === 'ok') {
        echo '<p class="message-success">&#10003; Commune enregistrée avec succès.</p>';
    } elseif ($_GET['statut'] === 'erreur') {
        $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "Erreur inconnue.";
        echo '<p class="message-error">&#10007; Erreur : ' . $msg . '</p>';
    }
}
?>


<div class="form-container">
    <h2>Saisie des communes</h2>

    <form action="enregistrement.php" method="POST">

        <div class="form-row">
            <label for="nomCommune">Nom de la commune</label>
            <input type="text" id="nomCommune" name="lib_Commune"
                   placeholder="xxxxxx" required>
        </div>

        <div class="form-row">
            <label for="id_depart">Département</label>
            <select id="id_depart" name="id_depart" required>
                <option value="">-- Choisir --</option>
                <?php
                
                $sql = "SELECT id_departement, lib_depart FROM departement ORDER BY lib_depart ASC";
                $result = mysqli_query($connexion, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['id_departement']) . '">'
                           . htmlspecialchars($row['lib_depart']) . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>Aucun département trouvé</option>';
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