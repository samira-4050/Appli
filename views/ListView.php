<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  <!-- Lien vers le CSS de Bootstrap -->
</head>
<body class="bg-light">

<div class="container py-5">  <!-- Conteneur principal avec du padding (espace intérieur) -->
    <h2 class="text-center text-primary mb-4">📋 Liste des utilisateurs</h2>
    <!-- Titre centré avec style bleu -->

    <form class="mb-4" method="get">  <!-- Formulaire de recherche envoyé en GET -->
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Rechercher par ID, nom ou prénom..." value="<?= htmlspecialchars($search) ?>">
            <!-- Champ texte qui garde la recherche précédente si elle existe -->
            <button class="btn btn-primary" type="submit"> 🔍 Rechercher</button>  <!-- Bouton pour envoyer la recherche -->
        </div>
    </form>

    <table class="table table-bordered table-hover bg-white shadow">   <!-- Tableau Bootstrap avec bordures et survol -->
        <thead class="table-primary text-center">  <!-- En-tête du tableau en bleu clair -->
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody class="text-center">
        <?php foreach ($users as $row): ?> <!-- Boucle sur les résultats récupérés dans la base -->
            <tr>
                <td><?= htmlspecialchars($row['Id']) ?></td>
                <td><?= htmlspecialchars($row['nom']) ?></td>
                <td><?= htmlspecialchars($row['prenom']) ?></td>
                <td><?= htmlspecialchars($row['statut']) ?></td>
                <td>
                    <a href="UserController.php?action=modifier&id=<?= $row['Id'] ?>" class="btn btn-sm btn-warning">✏️Modifier</a>
                    <a href="UserController.php?action=supprimer&id=<?= $row['Id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">🗑️Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="../index.php" class="btn btn-outline-secondary"> ⬅ Retour au menu</a> <!-- Bouton pour revenir à la page d’accueil -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script JS de Bootstrap (pour les composants dynamiques si besoin) -->
</body>
</html>