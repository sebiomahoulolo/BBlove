<?php
include '../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "Utilisateur non trouvé";
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
  echo "Utilisateur introuvable";
  exit;
}

// Mise à jour si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_role = $_POST['role'];
  $pdo->prepare("UPDATE users SET role = ? WHERE id = ?")->execute([$new_role, $id]);

  echo "<script>alert('✅ Rôle mis à jour avec succès'); window.location.href='../admin_dashboard.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier rôle utilisateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h3 class="mb-4">Modifier le rôle de <strong><?= htmlspecialchars($user['nom']) ?></strong></h3>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Rôle :</label>
      <select name="role" class="form-select">
        <option value="utilisateur" <?= $user['role'] === 'utilisateur' ? 'selected' : '' ?>>Utilisateur</option>
        <option value="coach" <?= $user['role'] === 'coach' ? 'selected' : '' ?>>Coach</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
    <a href="../admin_dashboard.php" class="btn btn-secondary">Annuler</a>
  </form>
</body>
</html>
