<?php
session_start();
include_once __DIR__ . '/../connexion.php';//Inclure une seule fois le fichier connexion.php situé dans le dossier parent, quel que soit l’endroit d’où le script est exécuté.
include_once __DIR__ . '/../model/UserModel.php';

$table = ($_SESSION['db'] ?? '') === 'UserTest' ? '[Users]' : '[User]';
$action = $_GET['action'] ?? 'lister';

switch ($action) {

    case 'ajouter':
        $erreurs = [];
        $statutsBDD = getDistinctStatuts($conn, $table);
        $statutsParDefaut = ['actif', 'inactif'];
        $statutsTous = array_unique(array_merge($statutsParDefaut, $statutsBDD));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $statut = $_POST['statut'];

            if (strlen($nom) < 2) $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
            if (strlen($prenom) < 2) $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";

            if (empty($erreurs)) {
                ajouterUtilisateur($conn, $table, $nom, $prenom, $statut);
                header("Location: UserController.php?action=lister");
                exit;
            }
        }
        include __DIR__ . '/../views/AjouterView.php';
        break;

    case 'lister':
    default:
    $search = $_GET['search'] ?? '';
    $filtreStatut = $_GET['statut'] ?? ''; // 🔹 Ajout du filtre par statut
    $triColonne = $_GET['tri'] ?? 'Id';     // 🔹 Ajout tri : colonne à trier (par défaut Id)
    $ordreTri = $_GET['ordre'] ?? 'ASC';    // 🔹 Ajout tri : ordre du tri
    $users = getUsers($conn, $search, $table, $filtreStatut, $triColonne, $ordreTri);
    // Optionnel : pour afficher les statuts disponibles dans le select
    $statutsBDD = getDistinctStatuts($conn, $table);
    $statutsParDefaut = ['actif', 'inactif'];
    $statutsTous = array_unique(array_merge($statutsParDefaut, $statutsBDD));

    include __DIR__ . '/../views/ListView.php';
    break;
    case 'modifier':
        $table = getTableName();
        $erreurs = [];
        $statutsBDD = getDistinctStatuts($conn, $table);
        $statutsParDefaut = ['actif', 'inactif'];
        $statutsTous = array_unique(array_merge($statutsParDefaut, $statutsBDD));
        $id = $_GET['id'] ?? '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $nouveauNom = trim($_POST['nom']);
            $nouveauPrenom = trim($_POST['prenom']);
            $statut = trim($_POST['statut']);

            $erreurs = validateUserModification($conn, $table, $id, $nouveauNom, $nouveauPrenom);

            if (empty($erreurs)) {
                updateUser($conn, $table, $id, $nouveauNom, $nouveauPrenom, $statut);
                header("Location: UserController.php?action=lister");
                exit;
            }
        }

        include __DIR__ . '/../views/ModifierView.php';
        break;

    case 'supprimer':
        $erreurs = [];
        $id = $_GET['id'] ?? '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];

            if (!is_numeric($id)) {
                $erreurs[] = "L'ID doit être un nombre.";
            } elseif (!verifierIdExistant($conn, $id, $table)) {
                $erreurs[] = "Aucun utilisateur trouvé avec l'ID $id.";
            }

            if (empty($erreurs)) {
                supprimerUtilisateur($conn, $id, $table);
                header("Location: UserController.php?action=lister");
                exit;
            }
        }

        include __DIR__ . '/../views/SupprimerView.php';
        break;
}

?>