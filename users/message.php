<?php
include 'db.php';
include 'verifier_abonnement.php';

$mon_id = $_SESSION['user_id'];
$ami_id = $_GET['to'] ?? null;

// 🔍 Liste des utilisateurs avec qui on a discuté
$stmt = $pdo->prepare("SELECT DISTINCT IF(expediteur_id = ?, destinataire_id, expediteur_id) AS ami_id,
                              u.nom, u.identifiant, p.photo
                       FROM messages m
                       JOIN users u ON u.id = IF(m.expediteur_id = ?, m.destinataire_id, m.expediteur_id)
                       LEFT JOIN profils p ON p.user_id = u.id
                       WHERE m.expediteur_id = ? OR m.destinataire_id = ?
                       ORDER BY m.date_envoi DESC");
$stmt->execute([$mon_id, $mon_id, $mon_id, $mon_id]);
$discussions = $stmt->fetchAll();

// 🔁 Récupération des messages si un ami est sélectionné
$messages = [];
if ($ami_id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE 
        (expediteur_id = ? AND destinataire_id = ?) OR 
        (expediteur_id = ? AND destinataire_id = ?) 
        ORDER BY date_envoi ASC");
    $stmt->execute([$mon_id, $ami_id, $ami_id, $mon_id]);
    $messages = $stmt->fetchAll();
}

// Vérifie si l'utilisateur est déjà bloqué
$checkBlocage = $pdo->prepare("SELECT * FROM blocages WHERE bloqueur_id = ? AND bloque_id = ?");
$checkBlocage->execute([$mon_id, $ami_id]);
$deja_bloque = $checkBlocage->rowCount() > 0;


// Récupérer tous les utilisateurs sauf toi
$stmtUsers = $pdo->prepare("SELECT id, nom, identifiant FROM users WHERE id != ?");
$stmtUsers->execute([$mon_id]);
$allUsers = $stmtUsers->fetchAll();


?>
<head>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.js"></script>

</head>
<style>
    .chat-container {
        display: flex;
        height: 75vh;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
    }
    .contacts {
        width: 30%;
        background: #fff;
        border-right: 1px solid #eee;
        overflow-y: auto;
    }
    .contacts a {
        display: block;
        padding: 15px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: #333;
    }
    .contacts a:hover {
        background: #f9f9f9;
    }
    .chat-box {
        width: 70%;
        display: flex;
        flex-direction: column;
        background: #fafafa;
    }
    .messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
    }
    .message-left, .message-right {
        max-width: 70%;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 15px;
        display: inline-block;
        clear: both;
    }
    .message-left {
        background: #eee;
        float: left;
    }
    .message-right {
        background: #ff5a5f;
        color: white;
        float: right;
    }
    .form-chat {
        display: flex;
        gap: 10px;
        padding: 15px;
        border-top: 1px solid #ddd;
        background: white;
    }
</style>

<?php
  include 'db.php';

$userId = $_SESSION['user_id'] ?? null;

// Récupérer la date d’inscription
$stmt = $pdo->prepare("SELECT date_inscription FROM users WHERE id = ?");
$stmt->execute([$userId]);
$dateInscription = $stmt->fetchColumn();

$joursDepuisInscription = (strtotime(date('Y-m-d')) - strtotime($dateInscription)) / (60*60*24);

// Vérifier abonnement actif
$stmt = $pdo->prepare("SELECT * FROM abonnements WHERE user_id = ? AND date_fin >= CURDATE()");
$stmt->execute([$userId]);
$abonnementActif = $stmt->fetch();

if ($joursDepuisInscription > 7 && !$abonnementActif) {
  // Rediriger ou bloquer
  echo "<div class='alert alert-warning'>Vous devez vous abonner pour accéder à cette fonctionnalité.</div>";
  echo "<a href='abonnement_user.php' class='btn btn-primary'>S’abonner</a>";
  exit;
}

?>

<h3 class="mb-3 text-danger">💬 Messagerie privée</h3>

<div class="chat-container">
    <div class="contacts">
  <button id="nouveau-message-btn" style="width: 100%; padding: 10px; background:#ff5a5f; color:#fff; border:none; cursor:pointer; font-weight:bold;">
    + Nouveau message
  </button>

  <div id="liste-contacts">
    <?php foreach ($discussions as $contact): ?>
      <a href="dashboard.php?page=messages&to=<?= $contact['ami_id'] ?>">
          <strong><?= htmlspecialchars($contact['nom']) ?></strong><br>
          <small>@<?= htmlspecialchars($contact['identifiant']) ?></small>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<div id="nouveau-message-form" style="display:none; padding:10px; background:#fafafa; border-top:1px solid #ddd;">
  <form action="dashboard.php" method="GET">
    <input type="hidden" name="page" value="messages">
    <label for="new-to">Choisir un utilisateur :</label><br>
    <select name="to" id="new-to" required style="width: 100%; margin-bottom: 10px;">
      <option value="">-- Sélectionner --</option>
      <?php foreach ($allUsers as $user): ?>
        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['nom']) ?> (@<?= htmlspecialchars($user['identifiant']) ?>)</option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-danger" style="width: 100%;">Démarrer la discussion</button>
  </form>
</div>


  

    <!-- Zone de chat -->
    <div class="chat-box">
        <?php if ($ami_id): ?>
            <div class="messages" id="messages">
                <?php foreach ($messages as $msg): ?>
                    <div class="<?= $msg['expediteur_id'] == $mon_id ? 'message-right' : 'message-left' ?>">
                        <?php if ($msg['type'] == 'texte'): ?>
                            <?= nl2br(htmlspecialchars($msg['contenu'])) ?>
                        <?php elseif ($msg['type'] == 'image'): ?>
                            <img src="<?= htmlspecialchars($msg['fichier']) ?>" style="max-width:100%; border-radius: 10px;">
                        <?php elseif ($msg['type'] == 'video'): ?>
                            <video controls width="200">
                                <source src="<?= htmlspecialchars($msg['fichier']) ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- <a href="https://meet.jit.si/LovingMatch_<?= $mon_id ?>_<?= $ami_id ?>" target="_blank" class="btn btn-outline-primary">
                📞 Appel Audio / Vidéo
            </a> -->

            <div class="d-flex justify-content-end mb-2">
                <?php if ($deja_bloque): ?>
                    <a href="messages/deblocage_user.php?bloque_id=<?= $ami_id ?>" class="btn btn-success btn-sm">✅ Débloquer cet utilisateur</a>
                <?php else: ?>
                    <a href="messages/blocage_user.php?bloque_id=<?= $ami_id ?>" class="btn btn-outline-danger btn-sm">🚫 Bloquer cet utilisateur</a>
                <?php endif; ?>
            </div>

            <!-- Formulaire d'envoi -->
            <form action="messages/envoyer_message.php" method="POST" enctype="multipart/form-data" class="form-chat">
                <input type="hidden" name="destinataire_id" value="<?= $ami_id ?>">
                <input type="text" name="contenu" class="form-control" placeholder="Écrire un message..."> <button type="button" id="emoji-button" class="btn btn-light">😊</button>
                <input type="file" name="fichier" class="form-control" style="max-width:180px;">
                <button type="submit" class="btn btn-danger">Envoyer</button>
            </form>
        <?php else: ?>
            <div class="d-flex justify-content-center align-items-center h-100"> 
                <p class="text-muted">Sélectionnez une discussion à gauche pour commencer</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
  const button = document.querySelector('#emoji-button');
  const input = document.querySelector('input[name="contenu"]');
  const picker = new EmojiButton();

  picker.on('emoji', emoji => {
    input.value += emoji;
  });

  button.addEventListener('click', () => {
    picker.togglePicker(button);
  });
</script>

<script>
  const amiId = <?= json_encode($ami_id) ?>;
  const container = document.getElementById('messages');

  setInterval(() => {
    fetch('messages/load_messages.php?to=' + amiId)
      .then(res => res.text())
      .then(data => {
        container.innerHTML = data;
        container.scrollTop = container.scrollHeight;
      });
  }, 3000);
</script>

<script>
  const btnNouveau = document.getElementById('nouveau-message-btn');
  const formNouveau = document.getElementById('nouveau-message-form');

  btnNouveau.addEventListener('click', () => {
    if (formNouveau.style.display === 'none') {
      formNouveau.style.display = 'block';
      btnNouveau.textContent = '✖ Annuler';
    } else {
      formNouveau.style.display = 'none';
      btnNouveau.textContent = '+ Nouveau message';
    }
  });
</script>
