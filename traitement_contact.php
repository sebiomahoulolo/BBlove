<?php
// Connexion à la base de données
include'db.php';
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

// Préparation et insertion
$stmt = $conn->prepare("INSERT INTO messages_contact (nom, prenom, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nom, $prenom, $email, $message);
$stmt->execute();
$stmt->close();
$conn->close();

// Récupération des données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Configuration de l'email
$to = "contactbblove2@gmail.com"; // Ton adresse email de réception
$sujet = "Nouveau message de contact de $prenom $nom";
$contenu = "
Vous avez reçu un nouveau message depuis le site :

Nom : $nom
Prénom : $prenom
Email : $email

Message :
$message
";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoi de l'email
if (mail($to, $sujet, $contenu, $headers)) {
    echo "<script>alert('Merci pour votre message ! Nous vous répondrons très vite ❤️'); window.location.href='contact.php';</script>";
} else {
    echo "<script>alert('Erreur lors de l\'envoi du message. Veuillez réessayer.'); window.location.href='contact.php';</script>";
}


?>