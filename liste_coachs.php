<?php
include 'db.php';

// Récupérer la dernière demande de l'utilisateur
$last = $pdo->query("SELECT * FROM search_coach ORDER BY id DESC LIMIT 1")->fetch();

if (!$last) {
  echo "<div class='alert alert-warning text-center'>Aucune demande trouvée.</div>";
  exit;
}

$categorie = $last['categorie_demande'];

// Récupérer les coachs avec cette catégorie
$coach_stmt = $pdo->prepare("SELECT * FROM coach_categories 
                             INNER JOIN utilisateurs ON coach_categories.user_id = utilisateurs.id 
                             WHERE coach_categories.categorie = ?");
$coach_stmt->execute([$categorie]);
$coachs = $coach_stmt->fetchAll();
?>

<div class="container my-5">
  <h3 class="text-danger text-center mb-4">Coach(s) disponibles en “<?= htmlspecialchars($categorie) ?>”</h3>

  <?php if (count($coachs) === 0): ?>
    <div class="alert alert-info text-center">Aucun coach disponible pour cette catégorie pour le moment.</div>
  <?php else: ?>
    <table class="table table-bordered table-striped">
      <thead class="table-danger">
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Catégorie</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($coachs as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['nom']) . ' ' . htmlspecialchars($c['prenom']) ?></td>
            <td><?= htmlspecialchars($c['email']) ?></td>
            <td><?= htmlspecialchars($c['categorie']) ?></td>
            <td>
              <a href="contacter_coach.php?coach_id=<?= $c['user_id'] ?>&demande_id=<?= $last['id'] ?>" class="btn btn-outline-danger btn-sm">Contacter</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
