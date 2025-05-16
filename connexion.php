<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$selectedDb = $_SESSION['db'] ?? 'AppliUsers';

$serverName = "MONORDINATEUR\\SQLEXPRESS";   //Nom de ton serveur SQL Server. Indique le nom de l'ordinateur et l'instance SQL Server utilisée.
$username = "phpuser"; //Identifiants d’un compte SQL Server autorisé à accéder à la base
$password = "php123!";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$selectedDb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Si une erreur arrive, elle sera affichée clairement (en mode "exception").
    echo "<p class='text-success'>✅ Connexion réussie à la base : <strong>" . htmlspecialchars($selectedDb) . "</strong></p>";
    //Si la connexion fonctionne, ce message s'affiche.
} catch (PDOException $e) {                 //Si la connexion échoue, on affiche le message d'erreur.
    echo "Connexion échouée : " . $e->getMessage();
    $conn = null;
}
?>


