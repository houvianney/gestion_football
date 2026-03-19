<?php
// gestion_joueurs.php
include "connexion.php";

$sql = "SELECT j.id_Joueur, j.nom, j.prenom, j.photo, j.poste, c.nom_Club
        FROM   joueur j
        JOIN   club   c ON j.id_Club = c.id_Club
        ORDER  BY j.id_Joueur ASC";

$execution = mysqli_query($connexion, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des joueurs</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .photo-joueur {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #cc3333;
        }
        .btn-modifier  { background-color: #f0a500; color: #fff; border: none;
                         padding: 4px 10px; border-radius: 3px; cursor: pointer;
                         font-size: 11px; font-family: Arial, sans-serif; text-decoration: none; }
        .btn-supprimer { background-color: #cc3333; color: #fff; border: none;
                         padding: 4px 10px; border-radius: 3px; cursor: pointer;
                         font-size: 11px; font-family: Arial, sans-serif; text-decoration: none; }
        .btn-modifier:hover  { background-color: #c98a00; }
        .btn-supprimer:hover { background-color: #991111; }
        .lien-ajouter { font-family: Arial, sans-serif; font-size: 12px;
                        color: #cc3333; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<?php include('menu.php'); ?>

<?php if (isset($_GET['success'])): ?>
    <p class="message-success">&#10003;
        <?= $_GET['success'] === 'modif' ? 'Joueur modifié avec succès !' : 'Joueur supprimé avec succès !' ?>
    </p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p class="message-error">&#10007; Une erreur est survenue. Veuillez réessayer.</p>
<?php endif; ?>

<div class="table-container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h2 style="margin:0;">Liste des joueurs</h2>
        <a href="formulaire_joueur.php" class="lien-ajouter">+ Ajouter un joueur</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Poste</th>
                <th>Club</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!$execution || mysqli_num_rows($execution) === 0) {
            echo '<tr><td colspan="7" style="text-align:center;">Aucun joueur enregistré.</td></tr>';
        } else {
            $num = 1;
            while ($row = mysqli_fetch_assoc($execution)) :
                $photoSrc = (!empty($row['photo']))
                            ? 'uploads/' . $row['photo']
                            : 'uploads/default.png';
        ?>
            <tr>
                <td><?= $num++ ?></td>
                <td>
                    <img src="<?= htmlspecialchars($photoSrc) ?>"
                         alt="photo" class="photo-joueur"
                         onerror="this.src='uploads/default.png'">
                </td>
                <td><?= htmlspecialchars($row['nom'])      ?></td>
                <td><?= htmlspecialchars($row['prenom'])   ?></td>
                <td><?= htmlspecialchars($row['poste'])    ?></td>
                <td><?= htmlspecialchars($row['nom_Club']) ?></td>
                <td>
                    <a href="modifier_joueur.php?id=<?= $row['id_Joueur'] ?>"
                       class="btn-modifier">Modifier</a>
                    &nbsp;
                    <a href="supprimer_joueur.php?id=<?= $row['id_Joueur'] ?>"
                       class="btn-supprimer"
                       onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
        <?php
            endwhile;
        }
        ?>
        </tbody>
    </table>
</div>

<?php mysqli_close($connexion); ?>
</body>
</html>