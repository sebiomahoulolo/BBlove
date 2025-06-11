<?php
session_start();
require_once 'db.php'; // Ton fichier de connexion à la base de données

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Utilisateur non connecté.");
}

$userId = $_SESSION['user_id'];
$type = $_GET['type'] ?? null; // Le type d’abonnement transmis dans l’URL par FedaPay

// Vérification du type d’abonnement
$durations = [
    '2semaines' => 14,
    '1mois'     => 30,
    '3mois'     => 90,
    '1an'       => 365
];

if (!array_key_exists($type, $durations)) {
    die("Type d’abonnement invalide.");
}

// Calcul des dates
$date_debut = date('Y-m-d');
$date_fin = date('Y-m-d', strtotime("+{$durations[$type]} days"));

// Enregistrement dans la table des abonnements (ou table users si tu préfères)
$stmt = $pdo->prepare("REPLACE INTO abonnements (user_id, type, date_debut, date_fin) VALUES (?, ?, ?, ?)");
$stmt->execute([$userId, $type, $date_debut, $date_fin]);

// Redirection vers la page de confirmation
header("Location: mon_abonnement.php?success=1");
exit;
