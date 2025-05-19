<?php
function getTableName(): string
{
    return ($_SESSION['db'] ?? '') === 'UserTest' ? '[Users]' : '[User]';
}

function getUsers(PDO $conn, string $search = '', string $table = '[User]'): array
{
    $sql = "SELECT * FROM $table WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $sql .= " AND (CAST(Id AS VARCHAR) LIKE ? OR nom LIKE ? OR prenom LIKE ?)";
        $searchParam = '%' . $search . '%';
        $params = [$searchParam, $searchParam, $searchParam];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDistinctStatuts(PDO $conn, string $table): array
{
    $stmt = $conn->query("SELECT DISTINCT statut FROM $table");
    $statutsBDD = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $statutsParDefaut = ['actif', 'inactif'];
    return array_unique(array_merge($statutsParDefaut, $statutsBDD));
}

function ajouterUtilisateur(PDO $conn, string $table, string $nom, string $prenom, string $statut): bool
{
    $sql = "INSERT INTO $table (nom, prenom, statut) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$nom, $prenom, $statut]);
}

function validateUserModification(PDO $conn, string $table, $id, string $nom, string $prenom): array
{
    $erreurs = [];

    if (!is_numeric($id)) {
        $erreurs[] = "L'ID doit être un nombre.";
    } else {
        $verif = $conn->prepare("SELECT COUNT(*) FROM $table WHERE Id = ?");
        $verif->execute([$id]);
        if ($verif->fetchColumn() == 0) {
            $erreurs[] = "Aucun utilisateur avec l'ID $id.";
        }
    }

    if (strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
    }
    if (strlen($prenom) < 2) {
        $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";
    }

    return $erreurs;
}

function updateUser(PDO $conn, string $table, $id, string $nom, string $prenom, string $statut): bool
{
    $sql = "UPDATE $table SET nom = ?, prenom = ?, statut = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$nom, $prenom, $statut, $id]);
}

function verifierIdExistant(PDO $conn, $id, string $table): bool
{
    $sql = "SELECT COUNT(*) FROM $table WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn() > 0;
}

function supprimerUtilisateur(PDO $conn, $id, string $table): bool
{
    $sql = "DELETE FROM $table WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}
?>