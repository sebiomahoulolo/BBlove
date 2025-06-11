<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire

  $data = [
    'expediteur_nom'        => $_POST['expediteur_nom'],
    'expediteur_email'      => $_POST['expediteur_email'],
    'expediteur_tel'        => $_POST['expediteur_tel'],
    'expediteur_ville'      => $_POST['expediteur_ville'],
    'destinataire_nom'      => $_POST['destinataire_nom'],
    'destinataire_email'    => $_POST['destinataire_email'],
    'destinataire_tel'      => $_POST['destinataire_tel'],
    'destinataire_ville'    => $_POST['destinataire_ville'],
    'message'               => $_POST['message'] ?? null,
    'details_commande'      => $_POST['details_commande'] ?? null,
    'type_surprise'         => 'Surprise personnalisée',
    'date_livraison'        => $_POST['date_livraison'],
    'heure_livraison'       => $_POST['heure_livraison'],
    'statut'                => 'en_attente',
  ];

  // Si la commande vient d’un élément de la galerie
  if (!empty($_POST['item_id'])) {
    $item = $pdo->prepare("SELECT * FROM galerie_surprise WHERE id = ?");
    $item->execute([$_POST['item_id']]);
    $surprise = $item->fetch();

    if ($surprise) {
      $data['type_surprise'] = $surprise['titre'];
    }
  }

  // Enregistrer dans commandes_galerie
 $stmt = $pdo->prepare("INSERT INTO commandes_galerie (
  expediteur_nom, expediteur_email, expediteur_tel, expediteur_ville,
  destinataire_nom, destinataire_email, destinataire_tel, destinataire_ville,
  details_commande, message, type_surprise, date_livraison, heure_livraison, statut
) VALUES (
  :expediteur_nom, :expediteur_email, :expediteur_tel, :expediteur_ville,
  :destinataire_nom, :destinataire_email, :destinataire_tel, :destinataire_ville,
  :details_commande, :message, :type_surprise, :date_livraison, :heure_livraison, :statut
)");


  $stmt->execute($data);

  echo "<div style='padding: 40px; text-align: center; font-family: sans-serif;'> 
    <h2 style='color: #d00000;'>🎉 Merci !</h2> 
    <p>Votre commande a bien été envoyée.</p>
    <p>Veuillez procéder au paiement pour valider la commande.</p>
    <a href='paiement_galerie.php?id=" . $pdo->lastInsertId() . "' class='btn btn-danger mt-3'>Payer maintenant</a>
  </div>";
}
?>
