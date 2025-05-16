<?php
session_start();
include 'connexion.php';
$table = ($_SESSION['db'] === 'UserTest') ? '[Users]' : '[User]';
$erreurs = [];// On crée un tableau vide pour stocker les messages d'erreurs s’il y en a.

// Récupérer tous les statuts distincts dans la BDD
$sqlStatuts = "SELECT DISTINCT statut FROM $table";
$stmtStatuts = $conn->query($sqlStatuts);
$statutsBDD = $stmtStatuts->fetchAll(PDO::FETCH_COLUMN);

// Statuts standards à afficher en premier
$statutsParDefaut = ['actif', 'inactif'];

// Fusion sans doublons
$statutsTous = array_unique(array_merge($statutsParDefaut, $statutsBDD));

if ($_SERVER["REQUEST_METHOD"] === "POST") {   // On vérifie si le formulaire a été envoyé (soumis avec méthode POST)
    // On récupère les valeurs saisies dans le formulaire.
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $statut = $_POST['statut'];

    // Vérifie que le nom est assez long (au moins 2 lettres)
    if (strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
    }
    // Vérification prénom > 2 caractères
    if (strlen($prenom) < 2) {
        $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";
    }
    // Affichage des erreurs s’il y en a
    if (!empty($erreurs)) {
        echo "<div class='erreur'>";
        foreach ($erreurs as $e) {
            echo "<p>⚠️ $e</p>";
        }
        echo "</div>";
    }
    if (empty($erreurs)) {     // S’il n’y a aucune erreur, on prépare la requête d'insertion :
        // On insère les valeurs dans la base.
        $sql = "INSERT INTO $table (nom, prenom, statut) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $statut]);

        header("Location: lister.php");
        exit;   // Une fois terminé, on redirige vers la liste.
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Import de Bootstrap pour le style -->
    <style>
        body {
            background: #e3eaf1;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: rgba(51, 172, 93, 0.92);
        }
        .btn-outline-secondary:hover {
            background-color: #19bf66;
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                <h4>➕ Ajouter un utilisateur</h4>
                </div>

                <div class="card-body">
                    <?php if (!empty($erreurs)): ?> <!-- Vérifie si le tableau $erreurs contient au moins une erreur. Si oui → on affiche la zone d’alerte. -->
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <?php foreach ($erreurs as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post"> <!-- Formulaire envoyé par méthode POST -->
                        <div class="mb-3">  <!-- Champ texte pour le prénom -->
                            <label class="form-label">Nom :</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3"> <!-- Champ texte pour le prénom -->
                            <label class="form-label">Prénom :</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>

                        <div class="mb-3">  <!-- Menu déroulant pour choisir le statut -->
                            <label class="form-label">Statut :</label>
                            <select name="statut" class="form-select" required>
                                <?php foreach ($statutsTous as $s): ?> <!--À chaque tour de boucle, la variable $s contient un statut (ex : "actif", "inactif", "neutre"...).-->
                                    <option value="<?= htmlspecialchars($s) ?>"> <!--On met la valeur du statut dans l’attribut value.
                                                                                       htmlspecialchars($s) : protège le texte contre les caractères spéciaux HTML (ex: <, &, etc.). -->
                                        <?= ucfirst(htmlspecialchars($s)) ?> <!-- Affiche le texte du statut avec une majuscule au début (ucfirst = uppercase first letter). -->
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>  <!-- Bouton bleu largeur 100% -->
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-outline-secondary">⬅ Retour à l'accueil</a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>