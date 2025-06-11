<?php
include '../db.php';
$id = $_GET['id'] ?? null;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Récupérer l'événement en attente
    $stmt = $pdo->prepare("SELECT * FROM even WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();

    if ($event) {
        // Insérer dans la table 'evenements' (sans statut)
        $insert = $pdo->prepare("INSERT INTO evenements (titre, description, date_event, heure, lieu, image, payant, montant, type)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([
            $event['titre'],
            $event['description'],
            $event['date_event'],
            $event['heure'],
            $event['lieu'],
            $event['image'],
            $event['payant'],
            $event['montant'],
            $event['type']
        ]);

        // Supprimer l'événement de la table 'even'
        $delete = $pdo->prepare("DELETE FROM even WHERE id = ?");
        $delete->execute([$id]);

        header("Location: ../admin_dashboard.php");
        exit;
    }
}
?>
