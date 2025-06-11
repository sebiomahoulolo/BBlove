<?php
session_start();
include '../db.php';

$expediteur_id = $_SESSION['user_id'];
$destinataire_id = $_POST['destinataire_id'] ?? null;
$contenu = trim($_POST['contenu'] ?? '');
$type = 'texte';
$fichier_path = null;

if (!$destinataire_id || $expediteur_id == $destinataire_id) {
    exit("Erreur : destinataire non valide.");
}

// Gérer les fichiers (image ou vidéo)
if (!empty($_FILES['fichier']['name'])) {
    $fichier = $_FILES['fichier'];
    $nom_fichier = time() . '_' . basename($fichier['name']);
    $upload_dir = '../uploads/';
    $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
    $chemin_final = $upload_dir . $nom_fichier;

    $autorises_image = ['jpg', 'jpeg', 'png', 'gif'];
    $autorises_video = ['mp4', 'webm', 'ogg'];

    if (in_array($extension, $autorises_image)) {
        $type = 'image';
    } elseif (in_array($extension, $autorises_video)) {
        $type = 'video';
    } else {
        exit("Fichier non supporté.");
    }

    if (move_uploaded_file($fichier['tmp_name'], $chemin_final)) {
        $fichier_path = 'uploads/' . $nom_fichier;
    } else {
        exit("Échec de l’envoi du fichier.");
    }
}

// Insérer dans la base de données
$stmt = $pdo->prepare("INSERT INTO messages (expediteur_id, destinataire_id, contenu, type, fichier) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([
    $expediteur_id,
    $destinataire_id,
    $contenu,
    $type,
    $fichier_path
]);

// Redirection vers la conversation
header("Location: ../dashboard.php?page=messages&to=$destinataire_id");
exit();
