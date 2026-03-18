<?php
include "connexion.php";
$main_script = (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']));
if ($main_script) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php } ?>
    <?php if ($main_script) include('menu.php'); ?>

    <div class="table-container">
    <h2>Liste des projets enregistrés</h2>

    <?php
    
    $sql = "SELECT p.codeProjet,
                   p.nomProjet,
                   p.dateLancement,
                   p.duree,
                   l.nomLocalite
            FROM   Projet   p
            JOIN   Localite l ON p.codLocalite = l.codLocalite
            ORDER  BY p.dateLancement DESC";

    $result = mysqli_query($connexion, $sql);

    if (!$result) {
        echo '<p class="message-error">Erreur lors de la récupération : '
             . htmlspecialchars(mysqli_error($connexion)) . '</p>';
    } elseif (mysqli_num_rows($result) === 0) {
        echo '<p style="text-align:center;">Aucun projet enregistré pour l\'instant.</p>';
    } else {
    ?>
    <table>
        <thead>
            <tr>
                <th>Code projet</th>
                <th>Nom du projet</th>
                <th>Date de lancement</th>
                <th>Durée (jours)</th>
                <th>Localité</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['codeProjet'])    ?></td>
                <td><?= htmlspecialchars($row['nomProjet'])     ?></td>
                <td><?= htmlspecialchars($row['dateLancement']) ?></td>
                <td><?= htmlspecialchars($row['duree'])         ?></td>
                <td><?= htmlspecialchars($row['nomLocalite'])   ?></td>
                <td><a href="modification.php?code=<?= htmlspecialchars($row['codeProjet']) ?>" class="btn-modifier">Modifier</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php } ?>

</div>
<?php if ($main_script) { ?>
</body>
</html>
<?php } ?>