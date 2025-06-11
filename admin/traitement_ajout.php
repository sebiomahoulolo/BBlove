<?php
include '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$type || !$titre || !$description) {
        die("Tous les champs obligatoires doivent être remplis.");
    }

    // Upload image
    $image_url = null;
    if (!empty($_FILES['image']['name'])) {
        $imageDir = __DIR__ . '/uploads/images/';
        if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $imageDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $image_url = 'admin/uploads/images/' . $imageName;
        }
    }

    // Upload fichier
    $fichier_url = null;
    if (!empty($_FILES['fichier']['name'])) {
        $fichierDir = __DIR__ . '/uploads/fichiers/';
        if (!is_dir($fichierDir)) mkdir($fichierDir, 0755, true);
        $fileName = time() . '_' . basename($_FILES['fichier']['name']);
        $fichierPath = $fichierDir . $fileName;

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $fichierPath)) {
            $fichier_url = 'admin/uploads/fichiers/' . $fileName;
        } else {
            die("Erreur lors de l'upload du fichier.");
        }
    }

    if (($type === 'seance' || $type === 'video') && !$fichier_url) {
        die("Veuillez ajouter un fichier pour ce type de contenu.");
    }

    $sql = "INSERT INTO contenus (type, titre, description, fichier_url, image_url, date_publication)
            VALUES (:type, :titre, :description, :fichier_url, :image_url, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':type' => $type,
        ':titre' => $titre,
        ':description' => $description,
        ':fichier_url' => $fichier_url,
        ':image_url' => $image_url
    ]);

    header('Location: ../admin_dashboard.php?page=contenus');
    exit;
}
?>
