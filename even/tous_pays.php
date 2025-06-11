<?php
include '../db.php';

// Récupérer tous les pays, avec ou sans événement
$stmt = $pdo->query("
  SELECT p.nom AS pays, COUNT(e.id) AS nb_evenements
  FROM pays p
  LEFT JOIN evenements_pays e ON e.pays = p.nom
  GROUP BY p.nom
  ORDER BY p.nom ASC
");

$paysList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des pays - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #fef9f8, #f9f9f9);
      min-height: 100vh;
    }
    .container {
      max-width: 900px;
      padding: 60px 20px;
    }
    h2 {
      color: #ff5a5f;
      text-align: center;
      margin-bottom: 40px;
      font-weight: bold;
    }
    table {
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    thead th {
      background-color: #ff5a5f;
      color: white;
      text-align: center;
    }
    tbody td {
      vertical-align: middle;
      text-align: center;
    }
    .btn-link {
      color: #ff5a5f;
      font-weight: 500;
      text-decoration: none;
    }
    .btn-link:hover {
      text-decoration: underline;
      color: #d44d53;
    }
  </style>
</head>
<body>
<div class="container">
<a href="../even.php" class="btn btn-secondary btn-retour">&larr; Retour</a>

  <h2>Liste des pays</h2>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Nom du pays</th>
        <th>Nombre d'événements</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($paysList as $index => $p): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($p['pays']) ?></td>
          <td><?= $p['nb_evenements'] ?></td>
          <td>
            <?php if ($p['nb_evenements'] > 0): ?>
              <a href="even_pays.php?pays=<?= urlencode($p['pays']) ?>" class="btn-link">Voir les événements</a>
            <?php else: ?>
              <span class="text-muted">Aucun événement</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
