<?php
session_start();
include 'connexion.php';// On inclut le fichier qui se connecte à la base de données selon la base choisie (AppliUsers ou UserTest).
$search = $_GET['search'] ?? '';// On récupère le mot-clé tapé dans la barre de recherche (ou une chaîne vide si rien n'est tapé).
$table = ($_SESSION['db'] === 'UserTest') ? '[Users]' : '[User]';
$sql = "SELECT * FROM $table WHERE 1=1";
 // On prépare la requête de base qui récupère tous les utilisateurs.
$params = [];// On prépare un tableau vide pour les paramètres à envoyer dans la requête.

if (!empty($search)) {    // Si l'utilisateur a saisi quelque chose dans le champ de recherche :
    $sql .= " AND (CAST(Id AS VARCHAR) LIKE ? OR nom LIKE ? OR prenom LIKE ?)";  // On filtre : si l’ID (converti en texte), ou le nom ou le prénom contient le texte tapé.
    $searchParam = '%' . $search . '%'; // On ajoute les % pour rechercher ce que l’utilisateur a tapé, peu importe où ça apparaît.
    $params = [$searchParam, $searchParam, $searchParam];// On associe le même paramètre aux 3 conditions : ID, nom, prénom.
}

$stmt = $conn->prepare($sql);// On prépare la requête SQL avec PDO (sécurisé contre les injections).
$stmt->execute($params); // On exécute la requête en envoyant les paramètres.
?>


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
        </tr>
        </thead>
        <tbody class="text-center">
        <?php while ($row = $stmt->fetch()): ?> <!-- Boucle sur les résultats récupérés dans la base -->
            <tr>
                <td><?= htmlspecialchars($row['Id']) ?></td>
                <td><?= htmlspecialchars($row['nom']) ?></td>
                <td><?= htmlspecialchars($row['prenom']) ?></td>
                <td><?= htmlspecialchars($row['statut']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-secondary"> ⬅ Retour au menu</a> <!-- Bouton pour revenir à la page d’accueil -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script JS de Bootstrap (pour les composants dynamiques si besoin) -->
</body>
</html>