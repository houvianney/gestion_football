<?php
// tr_ajoutJoueur.php
include 'connexion.php';

if (isset($_POST['submit'])) {

    // ── 1. Récupération et sécurisation des données ──
    $nom     = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom  = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $id_Club = mysqli_real_escape_string($connexion, $_POST['id_Club']);
    $poste   = mysqli_real_escape_string($connexion, $_POST['poste']);

    // ── 2. Gestion de l'upload de la photo (identique à tr_ajoutVoie.php) ──
    $image_name = '';

    if (isset($_FILES["image_joueur"]) && $_FILES["image_joueur"]["error"] == UPLOAD_ERR_OK) {

        $target_dir    = "uploads/";
        $image_name    = time() . "_" . basename($_FILES["image_joueur"]["name"]);
        $target_file   = $target_dir . $image_name;
        $uploadOk      = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si c'est une vraie image
        $check = getimagesize($_FILES["image_joueur"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier (max 5 Mo)
        if ($_FILES["image_joueur"]["size"] > 5242880) {
            $uploadOk = 0;
        }

        // Autoriser certains formats
        if ($imageFileType != "jpg" && $imageFileType != "png"
            && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Upload du fichier
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["image_joueur"]["tmp_name"], $target_file)) {
                $uploadOk = 0;
            }
        }

        if ($uploadOk == 0) {
            header("location: formulaire_joueur.php?error=1");
            exit();
        }
    }

    // ── 3. Insertion en base de données ──
    $photo_value = $image_name ? "'$image_name'" : "NULL";

    $requete = "INSERT INTO joueur (nom, prenom, photo, id_Club, poste)
                VALUES ('$nom', '$prenom', $photo_value, '$id_Club', '$poste')";

    $execution = mysqli_query($connexion, $requete);

    if ($execution) {
        header("location: formulaire_joueur.php?success=1");
    } else {
        header("location: formulaire_joueur.php?error=4");
    }

} else {
    header("location: formulaire_joueur.php");
}
?>