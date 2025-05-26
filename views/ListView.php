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

    <!-- Barre de recherche + filtre statut -->
    <form method="get" class="mb-4 d-flex gap-3">
        <input type="text" class="form-control" name="search" placeholder="Rechercher par ID, nom ou prénom..." value="<?= htmlspecialchars($search) ?>">

        <select name="statut" class="form-select">
            <option value="">-- Tous les statuts --</option>
            <?php foreach ($statutsTous as $s): ?>
                <option value="<?= htmlspecialchars($s) ?>" <?= ($filtreStatut === $s) ? 'selected' : '' ?>>
                    <?= ucfirst(htmlspecialchars($s)) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-primary">🔍 Rechercher</button>
    </form>
    <!-- Tri dynamique -->
    <?php
    $ordreSuivantId = ($triColonne === 'Id' && $ordreTri === 'ASC') ? 'DESC' : 'ASC';
    $ordreSuivantNom = ($triColonne === 'nom' && $ordreTri === 'ASC') ? 'DESC' : 'ASC';
    $ordreSuivantPrenom = ($triColonne === 'prenom' && $ordreTri === 'ASC') ? 'DESC' : 'ASC';
    ?>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" action="UserController.php?action=actionGroupee">
    <table class="table table-bordered table-hover bg-white shadow">
        <thead class="table-primary text-center">
        <tr>
            <th><input type="checkbox" onclick="toggle(this)"></th>
            <th>
                <a href="?tri=Id&ordre=<?= $ordreSuivantId ?>&search=<?= htmlspecialchars($search) ?>&statut=<?= htmlspecialchars($filtreStatut) ?>" class="text-dark text-decoration-none">
                    ID <?= ($triColonne === 'Id') ? ($ordreTri === 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>
                <a href="?tri=nom&ordre=<?= $ordreSuivantNom ?>&search=<?= htmlspecialchars($search) ?>&statut=<?= htmlspecialchars($filtreStatut) ?>" class="text-dark text-decoration-none">
                    Nom <?= ($triColonne === 'nom') ? ($ordreTri === 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>
                <a href="?tri=prenom&ordre=<?= $ordreSuivantPrenom ?>&search=<?= htmlspecialchars($search) ?>&statut=<?= htmlspecialchars($filtreStatut) ?>" class="text-dark text-decoration-none">
                    Prénom <?= ($triColonne === 'prenom') ? ($ordreTri === 'ASC' ? '⬆️' : '⬇️') : '' ?>
                </a>
            </th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody class="text-center">
        <?php foreach ($users as $row): ?> <!-- Boucle sur les résultats récupérés dans la base -->
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?= $row['Id'] ?>"></td>
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

    <select name="action">
        <option value="">-- Action groupée --</option>
        <option value="set_inactif">Mettre en inactif</option>
        <option value="set_actif">Mettre en actif</option>
    </select>
    <button type="submit" class="btn btn-primary">Appliquer</button>
    </form>

    <script>
        function toggle(source) {
            const checkboxes = document.getElementsByName('ids[]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>

    <div class="text-center mt-3">
        <a href="../index.php" class="btn btn-outline-secondary"> ⬅ Retour au menu</a> <!-- Bouton pour revenir à la page d’accueil -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script JS de Bootstrap (pour les composants dynamiques si besoin) -->
</body>
</html>