<?php
$url = $_GET['url'] ?? null;

if (!$url || !file_exists($url)) {
    echo "Fichier introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Fichier - Aperçu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f8f8; padding: 30px; text-align: center; }
    iframe { border: none; width: 100%; height: 90vh; }
  </style>
</head>
<body>
  <h3 class="mb-3 text-danger">Aperçu du fichier</h3>
  <iframe src="<?= htmlspecialchars($url) ?>"></iframe>
</body>
</html>
