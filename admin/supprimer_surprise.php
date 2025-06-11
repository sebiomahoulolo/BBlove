<?php
// admin/supprimer_surprise.php

include'../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: ../admin_dashboard.php?page=voir_galerie');
    exit;
}

// Suppression dans la BDD
$stmt = $pdo->prepare("DELETE FROM galerie_surprise  WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../admin_dashboard.php?page=voir_galerie');
exit;
