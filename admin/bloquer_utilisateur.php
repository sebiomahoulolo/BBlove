<?php
include '../db.php';
session_start();

// Vérification si admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Inverser le statut de blocage (toggle)
    $stmt = $pdo->prepare("UPDATE users SET est_bloque = NOT est_bloque WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../admin_dashboard.php?page=utilisateurs");
    exit();
}
?>
