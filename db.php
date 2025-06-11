<?php
// Informations de connexion
$host = 'localhost'; // ou 127.0.0.1
$dbname = 'bblove';  // le nom de ta base
$username = 'root';  // ton utilisateur MySQL (par défaut 'root' en local)
$password = '';      // ton mot de passe MySQL (vide si WAMP/XAMPP)

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password,);
} catch (PDOException $e) {
    // En cas d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
