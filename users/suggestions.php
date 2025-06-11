<?php
include 'db.php';

$user_id = $_SESSION['user_id'];

// Charger le profil de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM profils WHERE user_id = ?");
$stmt->execute([$user_id]);
$mon_profil = $stmt->fetch();

if (!$mon_profil) {
    echo "<div class='alert alert-warning'>Complétez d'abord votre profil pour obtenir des suggestions.</div>";
    return;
}

$user_sex = $mon_profil['sex'] ?? null;

if ($user_sex === 'Homme') {
    $sexe_oppose = 'Femme';
} elseif ($user_sex === 'Femme') {
    $sexe_oppose = 'Homme';
} else {
    $sexe_oppose = null;
}

if ($sexe_oppose) {
    $query = $pdo->prepare("SELECT * FROM profils WHERE user_id != ? AND sex = ?");
    $query->execute([$user_id, $sexe_oppose]);
} else {
    $query = $pdo->prepare("SELECT * FROM profils WHERE user_id != ?");
    $query->execute([$user_id]);
}

$autres_profils = $query->fetchAll();

// Charger les autres profils
$query = $pdo->prepare("SELECT * FROM profils WHERE user_id != ?");
$query->execute([$user_id]);
$autres_profils = $query->fetchAll();

$suggestions = [];

foreach ($autres_profils as $profil) {
    $score = 0;

    // 1. Religion
    if (
        !empty($mon_profil['religion_partenaire']) &&
        $profil['religion_utilisateur'] === $mon_profil['religion_partenaire']
    ) {
        $score += 15;
    }

    // 2. Ville ou pays souhaité
    if (
        stripos($profil['ville'], $mon_profil['lieu_recherche']) !== false ||
        stripos($profil['lieu_recherche'], $mon_profil['ville']) !== false
    ) {
        $score += 15;
    }

    // 3. Tranche d’âge recherchée
    if (preg_match('/(\d+)-(\d+)/', $mon_profil['tranche_age_recherche'], $matches)) {
        $min = (int)$matches[1];
        $max = (int)$matches[2];
        if ($profil['age'] >= $min && $profil['age'] <= $max) {
            $score += 15;
        }
    }

    // 4. Centres d’intérêt communs (par mots-clés)
    $mes_interets = array_map('trim', explode(',', strtolower($mon_profil['interets'])));
    $ses_interets = array_map('trim', explode(',', strtolower($profil['interets'])));
    $commun = array_intersect($mes_interets, $ses_interets);
    $nb_communs = count($commun);

    if ($nb_communs >= 3) {
        $score += 20;
    } elseif ($nb_communs >= 1) {
        $score += 10;
    }

    // 5. Description partenaire et bio (similarité)
    $description_user = strtolower($mon_profil['description_partenaire']);
    $bio_profil = strtolower($profil['bio']);
    similar_text($description_user, $bio_profil, $pourcentage);
    if ($pourcentage > 30) {
        $score += 20;
    } elseif ($pourcentage > 15) {
        $score += 10;
    }

    // 6. Métier (proche)
    similar_text(strtolower($mon_profil['metier']), strtolower($profil['metier']), $match_metier);
    if ($match_metier > 40) {
        $score += 10;
    }

    $profil['score'] = min($score, 100);
    $suggestions[] = $profil;
}

// Trier les suggestions du plus au moins compatible
usort($suggestions, fn($a, $b) => $b['score'] <=> $a['score']);
?>

<h3 class="text-danger mb-4">💘 Profils Compatibles avec Vous</h3>

<?php if (empty($suggestions)): ?>
  <p>Aucun profil compatible pour le moment.</p>
<?php else: ?>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($suggestions as $profil): ?>
      <div class="col d-flex w-100 gap-30">
      <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($profil['photo'] ?? 'images/default.jpg') ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($profil['age']) ?> ans</h5>
                <p class="card-text"><?= htmlspecialchars($profil['ville']) ?></p>
                <p class="text-muted" style="font-size: 0.9em;">
                <?= htmlspecialchars(substr($profil['bio'], 0, 60)) ?>...
                </p>

                <?php
                // Refaire les intérêts pour affichage
                $interets_commun = array_intersect(
                array_map('trim', explode(',', strtolower($mon_profil['interets']))),
                array_map('trim', explode(',', strtolower($profil['interets'])))
                );
                ?>

                <?php if (count($interets_commun) > 0): ?>
                <p class="text-success mb-2">
                    <strong><?= count($interets_commun) ?> intérêt<?= count($interets_commun) > 1 ? 's' : '' ?> en commun :</strong><br>
                    <small><?= implode(', ', array_map('ucfirst', $interets_commun)) ?></small>
                </p>
                <?php endif; ?>

                <div class="progress mb-2">
                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $profil['score'] ?>%;">
                    <?= $profil['score'] ?>% compatible
                </div>
                </div>

                <a href="dashboard.php?page=voireprofil&id=<?= $profil['user_id'] ?>" class="btn btn-outline-danger btn-sm">Voir le profil</a>
                <a href="dashboard.php?page=messages&to=<?= $profil['user_id'] ?>" class="btn btn-danger btn-sm">Message</a>
                <a href="voir_galerie.php?id=<?= $profil['user_id'] ?>" class="btn btn-outline-primary btn-sm">Voir la galerie</a>


         </div>

      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

