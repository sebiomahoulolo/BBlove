<?php
include '../db.php';
$id = $_GET['id'] ?? null;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM even WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../admin_dashboard.php");
    exit;
}
?>
