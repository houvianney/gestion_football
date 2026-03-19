<?php
// joueurs_par_club.php — Question 6
include "connexion.php";

$sqlClubs = "SELECT id_Club, nom_Club FROM club ORDER BY nom_Club ASC";
$resClubs = mysqli_query($connexion, $sqlClubs);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joueurs par club</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .clubs-wrapper {
            max-width: 900px;
            margin: 30px auto;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .page-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #cc3333;
            margin-bottom: 24px;
        }
        .club-bloc {
            border: 1px solid #e0c0c0;
            margin-bottom: 28px;
            background: #fff;
        }
        .club-titre {
            background-color: #cc3333;
            color: #fff;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: bold;
        }
        .joueurs-grille {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 16px;
        }
        .carte-joueur {
            width: 115px;
            text-align: center;
        }
        .carte-joueur img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #cc3333;
            display: block;
            margin: 0 auto 8px auto;
        }
        .joueur-nom {
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }
        .badge-poste {
            display: inline-block;
            margin-top: 5px;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }
        .badge-gardien   { background-color: #e67e00; }
        .badge-défenseur { background-color: #1a7abf; }
        .badge-milieu    { background-color: #27a35a; }
        .badge-attaquant { background-color: #cc3333; }
        .aucun {
            padding: 10px 16px;
            font-size: 12px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
<?php include('menu.php'); ?>

<div class="clubs-wrapper">
    <p class="page-title">&#9917; Joueurs par club</p>

    <?php
    if (!$resClubs || mysqli_num_rows($resClubs) === 0) {
        echo '<p style="text-align:center;">Aucun club enregistré.</p>';
    } else {
        while ($club = mysqli_fetch_assoc($resClubs)) :
            $idClub  = $club['id_Club'];
            $nomClub = htmlspecialchars($club['nom_Club']);

            $sqlJ = "SELECT nom, prenom, photo, poste
                     FROM   joueur
                     WHERE  id_Club = $idClub
                     ORDER  BY id_Joueur ASC";
            $resJ = mysqli_query($connexion, $sqlJ);
    ?>
    <div class="club-bloc">
        <div class="club-titre">&#9917; <?= $nomClub ?></div>

        <?php if (!$resJ || mysqli_num_rows($resJ) === 0): ?>
            <p class="aucun">Aucun joueur enregistré dans ce club.</p>

        <?php else: ?>
            <div class="joueurs-grille">
            <?php while ($j = mysqli_fetch_assoc($resJ)):
                $photoSrc = (!empty($j['photo']))
                            ? 'uploads/' . $j['photo']
                            : 'uploads/default.png';
                $badgeClass = 'badge-' . $j['poste'];
            ?>
                <div class="carte-joueur">
                    <img src="<?= htmlspecialchars($photoSrc) ?>"
                         alt="<?= htmlspecialchars($j['nom']) ?>"
                         onerror="this.src='uploads/default.png'">
                    <div class="joueur-nom">
                        <?= htmlspecialchars($j['prenom']) ?><br>
                        <?= htmlspecialchars($j['nom']) ?>
                    </div>
                    <span class="badge-poste <?= $badgeClass ?>">
                        <?= ucfirst($j['poste']) ?>
                    </span>
                </div>
            <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endwhile; } mysqli_close($connexion); ?>
</div>

</body>
</html>