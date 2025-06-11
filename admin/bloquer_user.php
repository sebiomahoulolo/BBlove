<?php
include '../db.php';
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("UPDATE users SET statut = 'bloqué' WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ../admin_dashboard.php?page=abonnement');
    exit;
}
?>
