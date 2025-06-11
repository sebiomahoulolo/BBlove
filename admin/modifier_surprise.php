<?php
// admin/modifier_surprise.php

// Inclure la connexion à la BDD
include'../db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: ../admin_dashboard.php?page=voir_galerie');
    exit;
}

// Récupérer la surprise à modifier
$stmt = $pdo->prepare("SELECT * FROM galerie_surprise WHERE id = ?");
$stmt->execute([$id]);
$surprise = $stmt->fetch();

if (!$surprise) {
    echo "Surprise non trouvée.";
    exit;
}

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $prix = floatval($_POST['prix'] ?? 0);
    $image = $_POST['image'] ?? '';

    // Valider les données ici (à adapter)

    $stmt = $pdo->prepare("UPDATE galerie_surprise  SET titre = ?, description = ?, prix = ?, image = ? WHERE id = ?");
    $stmt->execute([$titre, $description, $prix, $image, $id]);

    header('Location: ../admin_dashboard.php?page=voir_galerie');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier surprise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Modifier surprise #<?= $surprise['id'] ?></h2>

    <form method="post">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="<?= htmlspecialchars($surprise['titre']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($surprise['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix (€)</label>
            <input type="number" name="prix" id="prix" class="form-control" step="0.01" value="<?= htmlspecialchars($surprise['prix']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">URL Image</label>
            <input type="text" name="image" id="image" class="form-control" value="<?= htmlspecialchars($surprise['image']) ?>" required>
            <!-- Pour uploader une image, prévoir un autre système -->
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="../admin_dashboard.php?page=voir_galerie" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
