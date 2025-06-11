<?php
session_start();
include '../db.php';

$currentUserId = $_SESSION['user_id'] ?? null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID utilisateur manquant ou invalide.'); window.history.back();</script>";
    exit;
}

$id = (int)$_GET['id'];

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Supprimer les messages liés à l'utilisateur
    $pdo->prepare("DELETE FROM messages WHERE expediteur_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM messages WHERE destinataire_id = ?")->execute([$id]);

    // Supprimer le profil lié
    $pdo->prepare("DELETE FROM profils WHERE user_id = ?")->execute([$id]);

    // Supprimer l'utilisateur
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);

    header("Location: ../admin_dashboard.php?page=utilisateurs&deleted=1");
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erreur lors de la suppression : " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    exit;
}
?>
