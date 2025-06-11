<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coach') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Vérifier si déjà sélectionné
$stmt = $pdo->prepare("SELECT categorie_id FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$row = $stmt->fetch();

if ($row && !empty($row['categorie_id'])) {
    header("Location: coach_dashboard.php");
    exit();
}

// Enregistrement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie_id = intval($_POST['categorie_id']);

    $stmt = $pdo->prepare("UPDATE users SET categorie_id = ? WHERE id = ?");
    $stmt->execute([$categorie_id, $user_id]);

    $_SESSION['categorie_id'] = $categorie_id;

    header("Location: coach_dashboard.php");
    exit();
}

// Récupération des catégories
$categories = $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Choisir votre catégorie</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      border-radius: 1rem;
    }
    @media (max-width: 576px) {
      h4 {
        font-size: 1.2rem;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-4 shadow w-100" style="max-width: 500px;">
      <h4 class="text-danger text-center mb-4">🧠 Choisissez votre domaine de coaching</h4>
      <form method="POST" novalidate>
        <div class="mb-3">
          <label for="categorie_id" class="form-label">Catégorie :</label>
          <select name="categorie_id" id="categorie_id" class="form-select" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-danger w-100">Valider ma catégorie</button>
      </form>
    </div>
  </div>
</body>
</html>
