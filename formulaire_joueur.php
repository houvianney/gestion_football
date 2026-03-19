<?php
// formulaire_joueur.php
include "connexion.php";

$sql       = "SELECT id_Club, nom_Club FROM club ORDER BY nom_Club ASC";
$execution = mysqli_query($connexion, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joueur - Ajouter un joueur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('menu.php'); ?>

<?php if (isset($_GET['success'])): ?>
    <p class="message-success">&#10003; Joueur ajouté avec succès !</p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p class="message-error">&#10007;
    <?php
    $error_messages = [
        '1' => 'Le fichier n\'est pas une image valide.',
        '2' => 'La taille de l\'image dépasse 5 Mo.',
        '3' => 'Format non autorisé (utilisez JPG, PNG, JPEG ou GIF).',
        '4' => 'Erreur lors de l\'enregistrement en base de données.',
        '5' => 'Erreur lors de l\'upload du fichier.',
    ];
    $code = $_GET['error'];
    echo isset($error_messages[$code]) ? $error_messages[$code] : 'Une erreur est survenue.';
    ?>
    </p>
<?php endif; ?>

<div class="form-container">
    <h2>Saisie des joueurs</h2>

    <form action="enregistrement joueur.php" method="POST" enctype="multipart/form-data">

        <div class="form-row">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" placeholder="xxxxxx" required>
        </div>

        <div class="form-row">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" placeholder="xxxxxx" required>
        </div>

        <div class="form-row">
            <label for="id_Club">Club</label>
            <select id="id_Club" name="id_Club" required>
                <option value="">-- Choisir un club --</option>
                <?php foreach ($execution as $c): ?>
                <option value="<?= $c['id_Club'] ?>">
                    <?= htmlspecialchars($c['nom_Club']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <label for="poste">Poste</label>
            <select id="poste" name="poste" required>
                <option value="">-- Choisir un poste --</option>
                <option value="gardien">Gardien</option>
                <option value="défenseur">Défenseur</option>
                <option value="milieu">Milieu</option>
                <option value="attaquant">Attaquant</option>
            </select>
        </div>

        <div class="form-row">
            <label for="image_joueur">Photo</label>
            <input type="file" id="image_joueur" name="image_joueur" accept="image/*">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit" name="submit">Soumettre</button>
            <button type="reset"  class="btn-cancel">Annuler</button>
        </div>

    </form>
</div>

<?php mysqli_close($connexion); ?>
</body>
</html>