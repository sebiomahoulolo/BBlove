<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE id = ?");
    $stmt->execute([$userId]);
}

// S'assurer que seul un coach accède
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coach') {
  header("Location: ../login.php");
  exit();
}

// Récupérer la catégorie
$stmt = $pdo->prepare("
    SELECT c.nom AS categorie_nom
    FROM users u
    LEFT JOIN categories c ON u.categorie_id = c.id
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$data = $stmt->fetch();
$categorie_nom = $data ? $data['categorie_nom'] : 'Non défini';


$page = $_GET['page'] ?? 'accueil';

$rdvs = $pdo->query("SELECT * FROM coaching_rdv ORDER BY date_reservation ASC")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord Coach</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #fdf6f9;
      font-family: 'Poppins', sans-serif;
    }

    .sidebar {
      background:rgb(222, 222, 228);
      width: 310px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      padding-top: 2rem;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
      box-shadow: 2px 0 12px rgba(0, 0, 0, 0.05);
    }

    .sidebar h2 {
      font-family: 'Playfair Display', serif;
      color:rgb(25, 2, 105);
    }

    .nav-link {
      color: rgb(25, 2, 105);
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: 500;
      font-size: 1.2rem;
      transition: all 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
      background-color: #fff;
      color: #842029;
    }

    .menu {
    margin-left: 220px;
    background-color: rgb(222, 222, 228);
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 350px;
  }

@media (max-width: 768px) {
  .menu {
    margin-left: 0;
    flex-direction: row;
    text-align: left;
    gap: 20px;
  }

 .menu .rounded p,
  .menu .d-flex {
    display: none !important;
  }

  .menu .rounded {
    margin-left: 10px !important;
  }

  .menu .rounded h3{
        font-size: 2rem;

  }

  #toggleSidebarBtn {
    display: block;
  }
}


    .main-content {
      background: #fff;
      padding: 10px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(220, 53, 103, 0.05);
      width: 1040px;
      margin-left: 300px; /* même largeur que .sidebar */
      margin-right: 20px;
    }

    h3, h4 {
      font-family: 'Playfair Display', serif;
      color: #ff5a5f;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    .btn-success, .btn-primary, .btn-danger {
      border-radius: 12px;
    }

    .btn-success {
      background-color: #ff5a5f;
      border: none;
    }

    .btn-success:hover {
      background-color:rgb(197, 7, 13);
    }

    .btn-primary {
      background-color: #ff5a5f;
      border: none;
    }

    .btn-primary:hover {
      background-color: rgb(197, 7, 13);
    }

    .btn-danger {
      background-color: red;
      border: none;
    }

    .btn-danger:hover {
      background-color:rgb(216, 9, 6);
    }

    table {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
    }

    thead {
      background-color: #ff5a5f;
      color:rgb(35, 27, 154);
    }

    td, th {
      vertical-align: middle;
    }

    .shadow-sm {
      box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    }

     #toggleSidebarBtn {
  display: none;
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1100;
  background-color:rgb(252, 112, 116);
  color: white;
  border: none;
  border-radius: 8px;
  padding: 20px;
}

      @media (max-width: 768px) {
    .sidebar {
      position: fixed;
      z-index: 1050;
      left: -310px;
      transition: left 0.3s ease;
    }

    .sidebar.show {
      left: 0;
    }

    .main-content {
      margin-left: 0 !important;
      width: 100% !important;
    }

    #toggleSidebarBtn {
      display: block;
    }
  }

 
  </style>
</head>
<body class="bg-light">


<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-12 col-md-2 sidebar shadow-sm" id="sidebar">
      <h2 class="text-center">Coach Panel</h2>
      <ul class="nav flex-column mt-4">
        <li class="nav-item"><a href="?page=accueil" class="nav-link">🏠 Accueil</a></li>
        <li class="nav-item"><a href="?page=ajouter_seance" class="nav-link">➕ Ajouter Séance</a></li>
        <li class="nav-item"><a href="?page=ajouter_article" class="nav-link">📝 Ajouter Article</a></li>
        <li class="nav-item"><a href="?page=ajouter_video" class="nav-link">🎥 Ajouter Vidéo/Audio</a></li>
        <li class="nav-item"><a href="?page=message" class="nav-link">💬 Messagerie</a></li>
        <li class="nav-item"><a href="?page=rdv" class="nav-link">📅 Rendez-vous</a></li>
        <!-- <li class="nav-item"><a href="?page=demandes" class="nav-link">Demandes de contacts</a></li> -->
        <li class="nav-item"><a href="logout.php" class="nav-link text-danger">🚪 Déconnexion</a></li>
        <li class="nav-item"><a href="?page=parametres" class="nav-link">⚙️ Paramètres</a></li>
      </ul>
    </div>

    <!-- Contenu principal -->
    <div class="col-md-10">
      <div class="menu">
        <div class="rounded" style="margin-left: 80px;">
          <h3 class="text-danger mb-1">
            Bienvenue, Coach <?= htmlspecialchars($_SESSION['nom']) ?> 💖
          </h3>
          <p class="text-muted d-none d-md-block">
            Catégorie sélectionnée :
            <strong class="text-dark"><?= htmlspecialchars($categorie_nom) ?></strong>
          </p>
        </div>

        <button id="toggleSidebarBtn"><i class="fas fa-bars" style="color: black;"></i></button>


        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 d-none d-md-flex">

          <!-- Notifications -->
          <div class="position-relative">
            <a href="?page=rdv" class="text-dark" aria-label="Notifications">
              <i class="fas fa-bell fa-lg"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php
                  $stmt = $pdo->prepare("SELECT COUNT(*) FROM coaching_rdv WHERE statut = 'en_attente' AND vue = 0");
                  $stmt->execute();
                  $notif_count = $stmt->fetchColumn();
                  echo $notif_count > 0 ? $notif_count : '';
                ?>
              </span>
            </a>
          </div>

          <!-- Profil -->
          <div class="dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle fa-lg me-1"></i> <?= htmlspecialchars($_SESSION['nom']) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="?page=profil">Mon profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php">Déconnexion</a></li>
            </ul>
          </div>
        </div>
      </div>

      </div>


  <div class="col-12 col-md-10 main-content">
        <?php if ($page === 'accueil'): ?>
          <h4 class=" mt-4" style="color: #ff5a5f;"> 📋 Mes séances / ateliers ajoutés</h4>
            <?php
            $coach_id = $_SESSION['user_id'];
            $seances = $pdo->prepare("SELECT * FROM coeur_brise_seance WHERE coach_id = ? ORDER BY date_event DESC");
            $seances->execute([$coach_id]);
            $seances = $seances->fetchAll();

            if (count($seances) === 0) {
                echo "<div class='alert alert-warning'>Aucune séance ajoutée pour l’instant.</div>";
            } else {
            ?>
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-danger">
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Lieu</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($seances as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['titre']) ?></td>
                    <td><?= htmlspecialchars($s['date_event']) ?></td>
                    <td><?= htmlspecialchars($s['heure']) ?></td>
                    <td><?= htmlspecialchars($s['lieu']) ?></td>
                    <td>
                    <a href="coach_actions/supprimer_seance.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette séance ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php } ?>
            <br>

            <h5 class="mt-4" style="color: #ff5a5f;">🗂️ Vos articles par catégorie</h5>
            <?php
            include'db.php';
            $articles = $pdo->prepare("SELECT * FROM blog_articles WHERE id = ? ORDER BY date_publication DESC");
            $articles->execute([$coach_id]);
            $groupes = [];
            foreach ($articles as $a) {
            $groupes[$a['categorie']][] = $a;
            }
            ?>

            <?php foreach ($groupes as $categorie => $liste): ?>
            <h6 class="mt-3 text-primary">📁 <?= htmlspecialchars($categorie) ?></h6>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($liste as $article): ?>
                    <tr>
                    <td><?= htmlspecialchars($article['titre']) ?></td>
                    <td><?= $article['date_publication'] ?></td>
                    <td>
                        <a href="coach_actions/modifier_article.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="coach_actions/supprimer_article.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
          <?php endforeach; ?>
       
        
        
        
        <?php elseif ($page === 'ajouter_seance'): ?>
          <h4>➕ Ajouter une Séance / Atelier</h4>
          <form method="POST" action="coach_actions/enregistrer_seance.php" enctype="multipart/form-data">
            <input type="text" name="titre" class="form-control mb-2" placeholder="Titre" required>
            <textarea name="description" class="form-control mb-2" rows="4" placeholder="Description" required></textarea>
            <input type="date" name="date_event" class="form-control mb-2" required>
            <input type="time" name="heure" class="form-control mb-2" required>
            <input type="text" name="lieu" class="form-control mb-2" placeholder="Lieu">
            <input type="file" name="image" class="form-control mb-3">
            <button class="btn btn-success">Ajouter</button>
        </form>

       <?php elseif ($page === 'ajouter_article'): ?>
            <h4 class="text-danger">📝 Ajouter un article (Blog)</h4>
            <form method="POST" action="coach_actions/enregistrer_article.php" enctype="multipart/form-data">
                <input type="text" name="titre" class="form-control mb-2" placeholder="Titre de l'article" required>
                <!-- Catégorie -->
                <select name="categorie" class="form-select mb-2" required>
                <option value="">-- Choisir une catégorie --</option>
                <option>Conseils de rencontres</option>
                <option>Vie de couple</option>
                <option>Rupture amoureuse</option>
                <option>Sexualité</option>
                <option>Romantisme</option>
                </select>
                <!-- Contenu -->
                <textarea name="contenu" class="form-control mb-2" rows="6" placeholder="Contenu de l'article..." required></textarea>
                <!-- Image -->
                <label for="image" class="form-label">Image de l'article</label>
                <input type="file" name="image" class="form-control mb-3" accept="image/*" required>

                <button class="btn btn-primary">📤 Publier</button>
        </form>

        <?php elseif ($page === 'ajouter_video'): ?>
          <h4>🎥 Ajouter une vidéo ou un audio (Coeurs brisés)</h4>
          <form method="POST" action="coach_actions/enregistrer_medias.php" enctype="multipart/form-data">
            <input type="text" name="titre" class="form-control mb-2" placeholder="Titre" required>
            <textarea name="description" class="form-control mb-2" rows="3" placeholder="Description" required></textarea>
            <select name="type" class="form-control mb-2" required>
              <option value="video">🎬 Vidéo</option>
              <option value="audio">🎧 Audio</option>
            </select>
            <input type="file" name="fichier" class="form-control mb-2" accept="video/*,audio/*" required>
            <button class="btn btn-success">Publier</button>
        </form>

       <?php elseif ($page === 'rdv'): ?>
  <?php
    include 'db.php';

    // On prépare et exécute correctement
    $rdv = $pdo->prepare("SELECT * FROM coaching_rdv ORDER BY date_reservation DESC");
    $rdv->execute(); // ⚠️ Obligatoire ici
  
        $update = $pdo->prepare("UPDATE coaching_rdv SET vue = 1 WHERE statut = 'en_attente'");
        $update->execute();

  ?>
  <h4>📅 Rendez-vous de coaching</h4>
  <div class="table-responsive card card-custom p-4">
    <table class="table table-hover">    
      <thead>
      <tr>
        <th>Nom</th><th>Email</th><th>Date</th><th>Heure</th><th>Statut</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rdv as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['nom']) ?></td>           
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= $r['date_rdv'] ?? 'Non défini' ?></td>
          <td><?= $r['heure_rdv'] ?? 'Non défini' ?></td>
          <td><?= htmlspecialchars($r['statut']) ?></td>
          <td>
            <a href="coach_actions/confirmer_rdv_form.php?id=<?= $r['rdv_id'] ?>" class="btn btn-sm btn-success">Confirmer</a>
            <a href="coach_actions/rejeter_rdv.php?id=<?= $r['rdv_id'] ?>" class="btn btn-sm btn-danger">Rejeter</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </div>


<?php elseif ($page === 'message'): 
include 'db.php';

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
  height: 85vh;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  background-color: #fff;
}

/* Liste des contacts */
.contacts {
  width: 30%;
  border-right: 1px solid #ddd;
  overflow-y: auto;
  padding: 10px;
  background: #f9f9f9;
}

.contacts a {
  display: block;
  padding: 8px;
  margin-bottom: 5px;
  border-radius: 8px;
  background: #fff;
  color: #333;
  text-decoration: none;
  border: 1px solid #eee;
  transition: background 0.2s;
}

.contacts a:hover {
  background:rgb(17, 11, 71);
  color: #fff;
}

.chat-box {
  width: 70%;
  display: flex;
  flex-direction: column;
  padding: 10px;
  position: relative;
}

.messages {
  display: flex;
  flex-direction: column;
  gap: 10px;
  overflow-y: auto;
  max-height: 60vh;
  padding: 10px;
}

/* Messages alignés gauche/droite */
.message-left,
.message-right {
  max-width: 50%;
  padding: 10px 15px;
  border-radius: 20px;
  font-size: 14px;
  line-height: 1.4;
  word-wrap: break-word;
}

/* Messages à gauche (utilisateur distant) */
.message-left {
  align-self: flex-start;
  background-color:rgb(234, 230, 252);
  color: #000;
  border-top-left-radius: 0;
}

/* Messages à droite (utilisateur connecté) */
.message-right {
  align-self: flex-end;
  background-color:rgb(20, 10, 107);
  color: #fff;
  border-top-right-radius: 0;
}

/* Formulaire */
.form-chat {
  display: flex;
  gap: 8px;
  align-items: center;
  flex-wrap: wrap;
}

.form-chat input[type="text"] {
  flex: 1;
}

.form-chat input[type="file"] {
  flex-shrink: 1;
}

/* ✅ Responsive Mobile */
@media (max-width: 768px) {
  .chat-container {
    flex-direction: column;
    height: auto;
  }

  .contacts {
    width: 100%;
    height: auto;
    border-right: none;
    border-bottom: 1px solid #ddd;
  }

  .chat-box {
    width: 100%;
    height: auto;
  }

  .form-chat {
    flex-direction: column;
    align-items: stretch;
  }

  .form-chat input[type="text"],
  .form-chat input[type="file"],
  .form-chat button {
    width: 100%;
    margin-bottom: 5px;
  }

  .messages {
    max-height: 50vh;
  }
}

</style>

<h3 class="mb-3 text-danger">💬 Messagerie privée</h3>

<div class="chat-container">
    <div class="contacts">
  <button id="nouveau-message-btn" style="width: 100%; padding: 10px; background:rgb(50, 18, 109); color:#fff; border:none; cursor:pointer; font-weight:bold;">
    + Nouveau message
  </button>

  <div id="liste-contacts">
    <?php foreach ($discussions as $contact): ?>
      <a href="coach_dashboard.php?page=message&to=<?= $contact['ami_id'] ?>">
          <strong><?= htmlspecialchars($contact['nom']) ?></strong><br>
          <small>@<?= htmlspecialchars($contact['identifiant']) ?></small>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<div id="nouveau-message-form" style="display:none; padding:10px; background: #fafafa; border-top:1px solid #ddd;">
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
            <form action="messages/envoi_message.php" method="POST" enctype="multipart/form-data" class="form-chat">
                <input type="hidden" name="destinataire_id" value="<?= $ami_id ?>">
                <input type="text" name="contenu" class="form-control" placeholder="Écrire un message..."> <button type="button" id="emoji-button" class="btn btn-light">😊</button>
                <input type="file" name="fichier" class="form-control" style="max-width:180px;">
                <button type="submit" class="btn btn-danger" style="background-color:rgb(24, 12, 128)">Envoyer</button>
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


          <?php elseif ($page === 'parametres'): ?>
            <h4 class="text-danger">⚙️ Paramètres du compte</h4>

            <!-- Réinitialisation du mot de passe -->
            <form method="post" action="coach_actions/changer_motdepasse.php" class="mb-5">
              <h6>Changer de mot de passe</h6>
              <div class="mb-2">
                <input type="password" name="nouveau_mdp" class="form-control" placeholder="Nouveau mot de passe" required>
              </div>
              <button class="btn btn-outline-primary">Mettre à jour</button>
            </form>

            <!-- Suppression du compte -->
            <form method="post" action="coach_actions/supprimer_compte.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
              <h6 class="text-danger">Supprimer mon compte</h6>
              <button class="btn btn-outline-danger">Supprimer définitivement</button>
          </form>

            <?php elseif ($page === 'profil'): ?>
            <h4 class="text-danger mb-4">👤 Mon profil</h4>
            <?php
              include'db.php';
              $id = $_SESSION['user_id'];
              $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
              $stmt->execute([$id]);
              $coach = $stmt->fetch();
            ?>

            <table class="table table-bordered">
              <tr><th>Nom</th><td><?= htmlspecialchars($coach['nom']) ?></td></tr>
              <tr><th>Email</th><td><?= htmlspecialchars($coach['email']) ?></td></tr>
              <tr><th>Téléphone</th><td><?= htmlspecialchars($coach['telephone'] ?? 'Non renseigné') ?></td></tr>
              <tr><th>Catégorie</th><td><?= htmlspecialchars($coach['categorie'] ?? 'Non sélectionnée') ?></td></tr>
              <tr><th>Date d'inscription</th><td><?= date('d/m/Y', strtotime($coach['date_inscription'])) ?></td></tr>
            </table>

            <a href="?page=parametres" class="btn btn-outline-primary mt-3">⚙️ Paramètres</a>


        <?php else: ?>
          <div class="alert alert-warning">Page inconnue.</div>
        <?php endif; ?>

    </div>
    </div>
  </div>
</div>

<script>
  const toggleBtn = document.getElementById('toggleSidebarBtn');
  const sidebar = document.getElementById('sidebar');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
  });
</script>

<!-- Bootstrap JS avec Popper (obligatoire pour les dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
