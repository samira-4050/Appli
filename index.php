<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Application utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7ff, #ffffff);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .full-height {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .form-select, .btn, .alert {
            max-width: 400px;
            width: 100%;
        }
        .btn {
            padding: 14px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="full-height text-center px-3">
    <h1 class="mb-4 text-primary">Bienvenue dans l'application</h1>

    <form method="post" class="mb-4 w-100" style="max-width: 400px;">
        <label for="db" class="form-label fw-semibold">Choisir une base de données :</label>
        <select name="db" id="db" class="form-select mb-3" required>
            <option value="AppliUsers" <?= ($_SESSION['db'] ?? '') === 'AppliUsers' ? 'selected' : '' ?>>AppliUsers (prod)</option>
            <option value="UserTest" <?= ($_SESSION['db'] ?? '') === 'UserTest' ? 'selected' : '' ?>>UserTest (test)</option>
        </select>
        <button type="submit" class="btn btn-outline-primary">Se connecter</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db'])) {
        $_SESSION['db'] = $_POST['db'];
        echo "<div class='alert alert-success text-center w-100 mb-4'>✅ Connecté à la base : <strong>{$_SESSION['db']}</strong></div>";
    }
    ?>

    <?php if (isset($_SESSION['db'])): ?>
        <div class="d-grid gap-3 w-100 px-3" style="max-width: 400px;">
            <a class="btn btn-primary" href="lister.php">📄 Liste des utilisateurs</a>
            <a class="btn btn-success" href="ajouter.php">➕ Ajouter un utilisateur</a>
            <a class="btn btn-warning text-dark" href="modifier.php">✏️Modifier un utilisateur</a>
            <a class="btn btn-danger" href="supprimer.php">🗑️ Supprimer un utilisateur</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
