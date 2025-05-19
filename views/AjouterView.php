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
                <a href="../index.php" class="btn btn-outline-secondary">⬅ Retour à l'accueil</a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>