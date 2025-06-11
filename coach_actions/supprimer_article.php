<?php
session_start();
include '../db.php';

// Vérifie l'ID de l'article
$id = $_GET['id'] ?? null;
if (!$id) {
  echo "ID d'article manquant.";
  exit();
}

// Vérifie que l'article existe
$stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
  echo "Article introuvable.";
  exit();
}

// Supprime le fichier image associé s’il existe
if (!empty($article['image']) && file_exists('../uploads/' . $article['image'])) {
  unlink('../uploads/' . $article['image']);
}

// Supprime l’article de la base
$pdo->prepare("DELETE FROM blog_articles WHERE id = ?")->execute([$id]);

// Redirection avec message (optionnel : vous pouvez ajouter une alerte de confirmation dans coach_dashboard.php)
header("Location: ../coach_dashboard.php?page=accueil");
exit();
?>
