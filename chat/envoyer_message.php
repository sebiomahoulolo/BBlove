<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    $pseudo = trim($_POST['name'] ?? '');

    if (!empty($message) && !empty($pseudo)) {
        $stmt = $pdo->prepare("INSERT INTO mesages (message, pseudo, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$message, $pseudo]);
        echo "OK";
    } else {
        echo "Champs manquants.";
    }
} else {
    echo "Méthode non autorisée.";
}
