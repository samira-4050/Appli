<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un prénom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>✏️ Modifier l'utilisateur</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($erreurs)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($erreurs as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post"  action="../controller/UserController.php?action=modifier">
                        <div class="mb-3">
                            <label class="form-label">ID de l'utilisateur :</label>
                            <input type="number" name="id" class="form-control" required  value="<?= htmlspecialchars($id ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nouveau Nom :</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nouveau Prénom :</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>

                        <div class="mb-3">
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

                        <button type="submit" class="btn btn-primary w-100">Modifier</button>
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