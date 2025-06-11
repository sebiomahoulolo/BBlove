<?php
session_start();
include '../db.php';

// Vérifie que c’est bien un coach
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coach') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $fichier_nom = $_FILES['fichier']['name'];
    $fichier_tmp = $_FILES['fichier']['tmp_name'];
    $chemin_upload = '../uploads/';
    $fichier_final = '';

    if (!empty($fichier_nom)) {
        $extension = pathinfo($fichier_nom, PATHINFO_EXTENSION);
        $type = (in_array(strtolower($extension), ['mp4', 'webm', 'mov'])) ? 'video' : 'audio';

        $nom_fichier_sauvegarde = time() . '_' . basename($fichier_nom);
        $fichier_final = $chemin_upload . $nom_fichier_sauvegarde;

        move_uploaded_file($fichier_tmp, $fichier_final);

        // Préparer les dates
        $date_ajout = date('Y-m-d');
        $expire_le = date('Y-m-d', strtotime('+7 days'));

        // Enregistrer dans la base
        $stmt = $pdo->prepare("INSERT INTO coeurs_brises_media (titre, type, fichier, date_ajout, expire_le) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $titre,
            $type,
            'uploads/' . $nom_fichier_sauvegarde, // chemin relatif
            $date_ajout,
            $expire_le
        ]);

        header("Location: ../coach_dashboard.php");
        exit;
    } else {
        echo "<div style='padding: 40px; text-align: center; font-family: sans-serif;'>
                <h2 style='color: red;'>❌ Erreur : Aucun fichier reçu</h2>
                <a href='../coach_dashboard.php?page=ajouter_video'>Retour</a>
              </div>";
    }
}
?>
