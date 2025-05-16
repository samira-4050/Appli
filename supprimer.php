<?php
session_start();
include 'connexion.php';
$table = ($_SESSION['db'] === 'UserTest') ? '[Users]' : '[User]';

$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];

    // Vérifier que l’ID est bien un nombre
    if (!is_numeric($id)) {
        $erreurs[] = "L'ID doit être un nombre.";
    } else {
        // Vérifier que l’ID existe en base
        $check = $conn->prepare("SELECT COUNT(*) FROM $table WHERE Id = ?");
        $check->execute([$id]);
        if ($check->fetchColumn() == 0) {
            $erreurs[] = "Aucun utilisateur trouvé avec l'ID $id.";
        }
    }

    // Si tout est bon, suppression
    if (empty($erreurs)) {
        $sql = "DELETE FROM $table WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: lister.php");
        exit;
    }
}
?>

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

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">ID de l'utilisateur à supprimer :</label>
                                <input type="number" name="id" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-danger w-100">Supprimer</button>
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

<?php
if (!empty($erreurs)) {
    echo "<div class='erreur'>";
    foreach ($erreurs as $e) {
        echo "<p>⚠️ $e</p>";
    }
    echo "</div>";
}
?>