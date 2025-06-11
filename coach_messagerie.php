<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coach') {
  header("Location: login.php");
  exit();
}

$coach_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messagerie Coach</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h3 class="text-primary mb-4">📨 Messagerie avec les utilisateurs</h3>

  <!-- Nouveau message -->
  <a href="?new=1" class="btn btn-success mb-3">➕ Nouveau message</a>

  <?php if (isset($_GET['new']) && $_GET['new'] == 1): ?>
    <h5>Démarrer une nouvelle conversation</h5>
    <form method="get" action="">
      <input type="hidden" name="page" value="messagerie">
      <div class="mb-3">
        <label for="user_id" class="form-label">Choisir un utilisateur :</label>
        <select name="id" id="user_id" class="form-select" required>
          <option value="" disabled selected>-- Sélectionnez un utilisateur --</option>
          <?php
            $stmtUsers = $pdo->query("SELECT id, prenom, nom FROM users");
            foreach ($stmtUsers as $user):
          ?>
            <option value="<?= $user['id'] ?>">
              <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Commencer</button>
    </form>
    <hr>
  <?php endif; ?>

  <!-- Liste des conversations -->
  <h5>📋 Conversations existantes</h5>
  <ul class="list-group mb-4">
    <?php
      $stmt = $pdo->prepare("
        SELECT DISTINCT mc.user_id, u.nom, u.prenom
        FROM messages_coach mc
        JOIN users u ON mc.user_id = u.id
        WHERE mc.coach_id = ?
        ORDER BY mc.date_envoi DESC
      ");
      $stmt->execute([$coach_id]);
      $conversations = $stmt->fetchAll();

      foreach ($conversations as $conv):
    ?>
      <li class="list-group-item">
        <a href="?id=<?= $conv['user_id'] ?>">
          💬 <?= htmlspecialchars($conv['prenom'] . ' ' . $conv['nom']) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

  <!-- Affichage de la discussion -->
  <?php if (isset($_GET['id'])):
    $user_id = $_GET['id'];

    $stmtMsg = $pdo->prepare("
      SELECT * FROM messages_coach
      WHERE coach_id = ? AND user_id = ?
      ORDER BY date_envoi ASC
    ");
    $stmtMsg->execute([$coach_id, $user_id]);
    $messages = $stmtMsg->fetchAll();
  ?>
    <h5>Discussion</h5>
    <div class="bg-white border p-3 rounded mb-3" style="max-height: 400px; overflow-y: auto;">
      <?php foreach ($messages as $msg): ?>
        <div class="mb-2">
          <strong><?= $msg['expediteur'] === 'coach' ? 'Vous' : 'Utilisateur' ?>:</strong>
          <?= nl2br(htmlspecialchars($msg['message'])) ?><br>
          <small class="text-muted"><?= $msg['date_envoi'] ?></small>
        </div>
      <?php endforeach; ?>
    </div>

    <form method="post" action="coach_actions/envoyer_message.php">
      <input type="hidden" name="user_id" value="<?= $user_id ?>">
      <textarea name="message" class="form-control mb-2" placeholder="Votre message..." required></textarea>
      <button class="btn btn-primary">Envoyer</button>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
