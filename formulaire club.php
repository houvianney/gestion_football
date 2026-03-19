<?php
include "connexion.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des clubs</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('menu.php'); ?>

<?php
if (isset($_GET['statut'])) {
    if ($_GET['statut'] === 'ok') {
        echo '<p class="message-success">&#10003; Club enregistré avec succès.</p>';
    } elseif ($_GET['statut'] === 'erreur') {
        $msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "Erreur inconnue.";
        echo '<p class="message-error">&#10007; Erreur : ' . $msg . '</p>';
    }
}
?>

<div class="form-container">
    <h2>Saisie des clubs</h2>

    <form action="enregistrement club.php" method="POST">

        <!-- Nom du club -->
        <div class="form-row">
            <label for="nom_Club">Nom du club</label>
            <input type="text" id="nom_Club" name="nom_Club"
                   placeholder="xxxxxx" required>
        </div>

        <!-- Département (filtre les communes) -->
        <div class="form-row">
            <label for="id_depart">Département</label>
            <select id="id_depart" name="id_depart_filtre" required>
                <option value="">-- Choisir un département --</option>
                <?php
                $sql = "SELECT id_departement, lib_depart FROM departement ORDER BY lib_depart ASC";
                $res = mysqli_query($connexion, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<option value="' . $row['id_departement'] . '">'
                       . htmlspecialchars($row['lib_depart']) . '</option>';
                }
                ?>
            </select>
        </div>

        <!-- Commune (peuplée dynamiquement selon le département) -->
        <div class="form-row">
            <label for="id_Commune">Commune</label>
            <select id="id_Commune" name="id_Commune" required>
                <option value="">-- Choisir d'abord un département --</option>
            </select>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Soumettre</button>
            <button type="reset"  class="btn-cancel"
                    onclick="document.getElementById('id_Commune').innerHTML=
                    '<option value=\\'\\'>-- Choisir d\\'abord un département --</option>'">
                Annuler
            </button>
        </div>

    </form>
</div>
<script>
document.getElementById('id_depart').addEventListener('change', function () {
    const idDepart  = this.value;
    const selectCommune = document.getElementById('id_Commune');

    selectCommune.innerHTML = '<option value="">-- Chargement... --</option>';

    if (!idDepart) {
        selectCommune.innerHTML = '<option value="">-- Choisir d\'abord un département --</option>';
        return;
    }

    fetch('get_communes.php?id_depart=' + idDepart)
        .then(response => response.json())
        .then(communes => {
            selectCommune.innerHTML = '<option value="">-- Choisir une commune --</option>';
            if (communes.length === 0) {
                selectCommune.innerHTML += '<option value="" disabled>Aucune commune dans ce département</option>';
            } else {
                communes.forEach(c => {
                    selectCommune.innerHTML +=
                        `<option value="${c.id_Commune}">${c.lib_Commune}</option>`;
                });
            }
        })
        .catch(() => {
            selectCommune.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>

</body>
</html>