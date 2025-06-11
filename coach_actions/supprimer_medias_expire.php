<?php
include '../db.php';

$aujourdHui = date('Y-m-d');

// Sélectionner les fichiers expirés
$expired = $pdo->query("SELECT id, fichier FROM coeurs_brises_media WHERE expire_le < '$aujourdHui'")->fetchAll();

foreach ($expired as $item) {
    $fichier = $item['fichier'];
    
    // Supprimer le fichier du dossier s'il existe
    if (file_exists("../" . $fichier)) {
        unlink("../" . $fichier);
    }

    // Supprimer l'entrée dans la base
    $stmt = $pdo->prepare("DELETE FROM coeurs_brises_media WHERE id = ?");
    $stmt->execute([$item['id']]);
}

echo "✅ Nettoyage terminé : " . count($expired) . " fichier(s) supprimé(s).";
