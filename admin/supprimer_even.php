<?php
include 'db.php'; // Fichier de connexion PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Préparation de la suppression
    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
    $stmt->execute([$id]);

    // Redirection avec message (optionnel)
    header("Location: admin_dashboard.php?page=evenements&msg=suppression_ok");
    exit;
} else {
    // Redirection si l'ID est invalide
    header("Location: admin_dashboard.php?page=evenements&msg=erreur");
    exit;
}
?>
