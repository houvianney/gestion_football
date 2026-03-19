<?php
// modifier_joueur.php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_Joueur'])) {

    $id             = intval($_POST['id_Joueur']);
    $nom            = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom         = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $id_Club        = mysqli_real_escape_string($connexion, $_POST['id_Club']);
    $poste          = mysqli_real_escape_string($connexion, $_POST['poste']);
    $ancienne_photo = mysqli_real_escape_string($connexion, $_POST['ancienne_photo']);

    $image_name = $ancienne_photo; // on conserve l'ancienne par défaut

    if (isset($_FILES["image_joueur"]) && $_FILES["image_joueur"]["error"] == UPLOAD_ERR_OK) {

        $target_dir    = "uploads/";
        $new_name      = time() . "_" . basename($_FILES["image_joueur"]["name"]);
        $target_file   = $target_dir . $new_name;
        $uploadOk      = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si c'est une vraie image
        $check = getimagesize($_FILES["image_joueur"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Taille max 5 Mo
        if ($_FILES["image_joueur"]["size"] > 5242880) {
            $uploadOk = 0;
        }

        // Formats autorisés
        if ($imageFileType != "jpg" && $imageFileType != "png"
            && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Upload
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image_joueur"]["tmp_name"], $target_file)) {
                $image_name = $new_name; // nouvelle photo enregistrée
            } else {
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 0) {
            header("location: gestion_joueurs.php?error=1");
            exit();
        }
    }

    // ── UPDATE en base de données ──
    $photo_value = $image_name ? "'$image_name'" : "NULL";

    $requete = "UPDATE joueur
                SET nom     = '$nom',
                    prenom  = '$prenom',
                    photo   = $photo_value,
                    id_Club = '$id_Club',
                    poste   = '$poste'
                WHERE id_Joueur = $id";

    if (mysqli_query($connexion, $requete)) {
        header("location: gestion_joueurs.php?success=modif");
    } else {
        header("location: gestion_joueurs.php?error=4");
    }

    mysqli_close($connexion);
    exit;
}

if (!isset($_GET['id'])) {
    header("location: gestion_joueurs.php");
    exit;
}

$id  = intval($_GET['id']);
$res = mysqli_query($connexion, "SELECT * FROM joueur WHERE id_Joueur = $id");

if (!$res || mysqli_num_rows($res) === 0) {
    header("location: gestion_joueurs.php");
    exit;
}
$j = mysqli_fetch_assoc($res);

$resClubs = mysqli_query($connexion, "SELECT id_Club, nom_Club FROM club ORDER BY nom_Club ASC");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un joueur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include('menu.php'); ?>

<div class="form-container">
    <h2>Modifier le joueur</h2>

    <form action="modifier_joueur.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_Joueur"      value="<?= $j['id_Joueur'] ?>">
        <input type="hidden" name="ancienne_photo"  value="<?= htmlspecialchars($j['photo']) ?>">

        <div class="form-row">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom"
                   value="<?= htmlspecialchars($j['nom']) ?>" required>
        </div>

        <div class="form-row">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom"
                   value="<?= htmlspecialchars($j['prenom']) ?>" required>
        </div>

        <div class="form-row">
            <label for="id_Club">Club</label>
            <select id="id_Club" name="id_Club" required>
                <option value="">-- Choisir --</option>
                <?php while ($c = mysqli_fetch_assoc($resClubs)) : ?>
                <option value="<?= $c['id_Club'] ?>"
                    <?= ($c['id_Club'] == $j['id_Club']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nom_Club']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-row">
            <label for="poste">Poste</label>
            <select id="poste" name="poste" required>
                <?php foreach (['gardien','défenseur','milieu','attaquant'] as $p) : ?>
                <option value="<?= $p ?>" <?= ($p === $j['poste']) ? 'selected' : '' ?>>
                    <?= ucfirst($p) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Photo actuelle -->
        <div class="form-row">
            <label>Photo actuelle</label>
            <?php $photoSrc = (!empty($j['photo'])) ? 'uploads/' . $j['photo'] : 'uploads/default.png'; ?>
            <img src="<?= htmlspecialchars($photoSrc) ?>"
                 alt="photo actuelle"
                 onerror="this.src='uploads/default.png'"
                 style="width:70px; height:70px; object-fit:cover;
                        border-radius:50%; border:2px solid #cc3333;">
        </div>

        <!-- Nouvelle photo (optionnel) -->
        <div class="form-row">
            <label for="image_joueur">
                Nouvelle photo
                <span style="font-weight:normal; color:#888;">(laisser vide pour conserver)</span>
            </label>
            <input type="file" id="image_joueur" name="image_joueur" accept="image/*">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Enregistrer</button>
            <button type="button" class="btn-cancel"
                    onclick="window.location='gestion_joueurs.php'">Annuler</button>
        </div>
    </form>
</div>

<?php mysqli_close($connexion); ?>
</body>
</html>