<?php
include 'db.php';


$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Utilisateur non connecté.");
}

// Récupérer le sexe de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT sex FROM profils WHERE user_id = ?");
$stmt->execute([$user_id]);
$user_sex = $stmt->fetchColumn();

// Récupérer la liste des villes disponibles
$villes = $pdo->query("SELECT DISTINCT ville FROM profils WHERE ville IS NOT NULL AND ville != '' ORDER BY ville")->fetchAll(PDO::FETCH_COLUMN);

$conditions = [];
$params = [];

// Valeurs par défaut pour le formulaire
$age_min_default = 18;
$age_max_default = 99;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des âges
    $age_min = filter_input(INPUT_POST, 'age_min', FILTER_VALIDATE_INT, [
        'options' => ['default' => $age_min_default, 'min_range' => 18, 'max_range' => 99]
    ]);
    $age_max = filter_input(INPUT_POST, 'age_max', FILTER_VALIDATE_INT, [
        'options' => ['default' => $age_max_default, 'min_range' => 18, 'max_range' => 99]
    ]);

    // Échanger si age_min > age_max
    if ($age_min > $age_max) {
        list($age_min, $age_max) = [$age_max, $age_min];
    }

    $ville = $_POST['ville'] ?? '';
    $interet = trim($_POST['interet'] ?? '');
    $avec_photo = isset($_POST['photo']);
    $selected_sex = $_POST['sex'] ?? '';

    // Filtre âge
    $conditions[] = "age BETWEEN ? AND ?";
    $params[] = $age_min;
    $params[] = $age_max;

    // Filtre sexe
   
        // Sinon on applique le filtre automatique du sexe opposé
        if ($user_sex === 'Homme') {
            $conditions[] = "sex = ?";
            $params[] = 'Femme';
        } elseif ($user_sex === 'Femme') {
            $conditions[] = "sex = ?";
            $params[] = 'Homme';
        }
    

    // Filtre ville
    if (!empty($ville)) {
        $conditions[] = "ville = ?";
        $params[] = $ville;
    }

    // Filtre centre d'intérêt
    if (!empty($interet)) {
        $conditions[] = "interets LIKE ?";
        $params[] = '%' . $interet . '%';
    }

    // Filtre photo
    if ($avec_photo) {
        $conditions[] = "photo IS NOT NULL AND photo != ''";
    }

    $sql = "SELECT * FROM profils";
    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $resultats = $stmt->fetchAll();
} else {
    $resultats = [];
    $age_min = $age_min_default;
    $age_max = 40; // Valeur par défaut affichée dans le formulaire
    $selected_sex = '';
    $ville = '';
    $interet = '';
    $avec_photo = false;
}
?>

<h3 class="text-danger mb-4">🔍 Recherche avancée</h3>

<form method="POST" class="mb-4">
  <div class="row g-3 align-items-end">
    <div class="col-md-2">
      <label>Âge min</label>
      <input type="number" name="age_min" class="form-control" value="<?= htmlspecialchars($age_min) ?>">
    </div>
    <div class="col-md-2">
      <label>Âge max</label>
      <input type="number" name="age_max" class="form-control" value="<?= htmlspecialchars($age_max) ?>">
    </div>

    <div class="col-md-2">
      <label>Ville</label>
      <select name="ville" class="form-select">
        <option value="">Toutes</option>
        <?php foreach ($villes as $v): ?>
          <option value="<?= htmlspecialchars($v) ?>" <?= ($ville === $v) ? 'selected' : '' ?>><?= htmlspecialchars($v) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label>Centre d’intérêt</label>
      <input type="text" name="interet" class="form-control" value="<?= htmlspecialchars($interet) ?>">
    </div>
    <div class="col-md-2">
      <div class="form-check mt-4">
        <input class="form-check-input" type="checkbox" name="photo" <?= $avec_photo ? 'checked' : '' ?>>
        <label class="form-check-label">Avec photo</label>
      </div>
    </div>
    <div class="col-md-12 text-end">
      <button type="submit" class="btn btn-danger">Rechercher</button>
    </div>
  </div>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <h5 class="mb-3">Résultats trouvés : <?= count($resultats) ?></h5>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($resultats as $profil): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="<?= !empty($profil['photo']) ? htmlspecialchars($profil['photo']) : 'images/default.jpg' ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($profil['age']) ?> ans</h5>
            <p class="card-text"><?= htmlspecialchars($profil['ville']) ?></p>
            <p class="text-muted" style="font-size: 0.9em;"><?= htmlspecialchars(substr($profil['bio'], 0, 60)) ?>...</p>

            <a href="dashboard.php?page=voireprofil&id=<?= $profil['user_id'] ?>" class="btn btn-outline-danger btn-sm">Voir le profil</a>
            <a href="dashboard.php?page=messages&to=<?= $profil['user_id'] ?>" class="btn btn-danger btn-sm">Message</a>
            <a href="voir_galerie.php?id=<?= $profil['user_id'] ?>" class="btn btn-outline-primary btn-sm">Voir la galerie</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
