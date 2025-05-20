<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-danger text-white text-center">
                    <h4>🗑️ Supprimer un utilisateur</h4>
                </div>
                <div class="card-body">

                    <?php if (!empty($erreurs)): ?>
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <?php foreach ($erreurs as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="../controller/UserController.php?action=supprimer">
                    <div class="mb-3">
                            <label class="form-label">ID de l'utilisateur à supprimer :</label>
                            <input type="number" name="id" class="form-control" required value="<?= htmlspecialchars($id ?? '') ?>">
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Supprimer</button>
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